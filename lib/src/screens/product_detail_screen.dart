import 'package:flutter/material.dart';

import '../models/product.dart';
import '../models/product_details.dart';
import '../services/product_service.dart';
import '../state/cart_controller.dart';
import '../widgets/product_card.dart';

class ProductDetailScreen extends StatefulWidget {
  const ProductDetailScreen({
    super.key,
    required this.initialProduct,
    required this.productService,
    required this.cart,
  });

  final Product initialProduct;
  final ProductService productService;
  final CartController cart;

  @override
  State<ProductDetailScreen> createState() => _ProductDetailScreenState();
}

class _ProductDetailScreenState extends State<ProductDetailScreen> {
  late Product product = widget.initialProduct;
  List<Product> relatedProducts = const [];
  bool isLoading = true;
  String? errorMessage;

  @override
  void initState() {
    super.initState();
    _loadProduct();
  }

  Future<void> _loadProduct() async {
    setState(() {
      isLoading = true;
      errorMessage = null;
    });

    try {
      final details = await widget.productService.fetchProduct(product.id);

      if (!mounted) {
        return;
      }

      setState(() {
        product = details.product;
        relatedProducts = details.relatedProducts;
      });
    } catch (_) {
      if (!mounted) {
        return;
      }

      setState(() {
        errorMessage = 'Product details could not be refreshed.';
      });
    } finally {
      if (mounted) {
        setState(() => isLoading = false);
      }
    }
  }

  Future<void> _addToCart(Product product) async {
    final added = await widget.cart.add(product);

    if (!mounted) {
      return;
    }

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          added ? 'Added to cart.' : widget.cart.errorMessage ?? 'Could not add to cart.',
        ),
      ),
    );
  }

  void _openProduct(Product product) {
    Navigator.of(context).push(
      MaterialPageRoute(
        builder: (_) => ProductDetailScreen(
          initialProduct: product,
          productService: widget.productService,
          cart: widget.cart,
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final imageUrl = product.imageUrl;

    return Scaffold(
      appBar: AppBar(title: Text(product.name)),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          AspectRatio(
            aspectRatio: 1,
            child: DecoratedBox(
              decoration: BoxDecoration(
                color: Theme.of(context).colorScheme.surfaceContainerHighest,
                borderRadius: BorderRadius.circular(8),
              ),
              child: imageUrl == null || imageUrl.isEmpty
                  ? const Icon(Icons.image_not_supported_outlined, size: 72)
                  : ClipRRect(
                      borderRadius: BorderRadius.circular(8),
                      child: Image.network(
                        imageUrl,
                        fit: BoxFit.cover,
                        errorBuilder: (context, error, stackTrace) {
                          return const Icon(Icons.image_not_supported_outlined, size: 72);
                        },
                      ),
                    ),
            ),
          ),
          const SizedBox(height: 20),
          if (isLoading) const LinearProgressIndicator(),
          if (errorMessage != null) ...[
            const SizedBox(height: 12),
            Text(
              errorMessage!,
              style: TextStyle(color: Theme.of(context).colorScheme.error),
            ),
          ],
          const SizedBox(height: 12),
          Text(
            product.category,
            style: Theme.of(context).textTheme.labelLarge?.copyWith(
              color: Theme.of(context).colorScheme.primary,
            ),
          ),
          const SizedBox(height: 6),
          Text(
            product.name,
            style: Theme.of(context).textTheme.headlineSmall?.copyWith(
              fontWeight: FontWeight.w700,
            ),
          ),
          const SizedBox(height: 10),
          Row(
            children: [
              Text(
                '\$${product.price.toStringAsFixed(2)}',
                style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  color: Theme.of(context).colorScheme.primary,
                  fontWeight: FontWeight.w700,
                ),
              ),
              if (product.oldPrice != null) ...[
                const SizedBox(width: 10),
                Text(
                  '\$${product.oldPrice!.toStringAsFixed(2)}',
                  style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                    decoration: TextDecoration.lineThrough,
                  ),
                ),
              ],
            ],
          ),
          const SizedBox(height: 16),
          Text(product.description.isEmpty ? 'No description yet.' : product.description),
          const SizedBox(height: 16),
          Text('In stock: ${product.quantity}'),
          const SizedBox(height: 20),
          FilledButton.icon(
            onPressed: widget.cart.isLoading ? null : () => _addToCart(product),
            icon: const Icon(Icons.add_shopping_cart),
            label: const Text('Add to cart'),
          ),
          const SizedBox(height: 28),
          Text(
            'Related products',
            style: Theme.of(context).textTheme.titleLarge,
          ),
          const SizedBox(height: 12),
          if (relatedProducts.isEmpty)
            const Text('No related products found yet.')
          else
            SizedBox(
              height: 300,
              child: ListView.separated(
                scrollDirection: Axis.horizontal,
                itemCount: relatedProducts.length,
                separatorBuilder: (_, _) => const SizedBox(width: 12),
                itemBuilder: (context, index) {
                  final related = relatedProducts[index];

                  return SizedBox(
                    width: 220,
                    child: ProductCard(
                      product: related,
                      onOpen: () => _openProduct(related),
                      onAddToCart: () => _addToCart(related),
                    ),
                  );
                },
              ),
            ),
        ],
      ),
    );
  }
}
