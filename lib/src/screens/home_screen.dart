import 'package:flutter/material.dart';

import '../models/product.dart';
import '../services/product_service.dart';
import '../state/cart_controller.dart';
import 'product_detail_screen.dart';
import '../widgets/product_card.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({
    super.key,
    required this.productService,
    required this.cart,
  });

  final ProductService productService;
  final CartController cart;

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  List<Product> products = const [];
  bool isLoading = false;
  String? errorMessage;

  @override
  void initState() {
    super.initState();
    _loadProducts();
  }

  Future<void> _loadProducts({String? search}) async {
    setState(() {
      isLoading = true;
      errorMessage = null;
    });

    try {
      final remoteProducts = await widget.productService.fetchProducts(
        search: search,
      );

      if (!mounted) {
        return;
      }

      setState(() {
        products = remoteProducts;
      });
    } catch (_) {
      if (!mounted) {
        return;
      }

      setState(() {
        products = const [];
        errorMessage = 'Could not load products from the Laravel API.';
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
    final featuredProducts = products.where((product) => product.isFeatured);
    final visibleFeatured = featuredProducts.isEmpty
        ? products.take(4).toList(growable: false)
        : featuredProducts.toList(growable: false);

    return CustomScrollView(
      slivers: [
        SliverAppBar.large(
          title: const _MatgarTitle(),
          actions: [
            IconButton(
              tooltip: 'Refresh products',
              onPressed: isLoading ? null : () => _loadProducts(),
              icon: const Icon(Icons.refresh),
            ),
          ],
        ),
        SliverPadding(
          padding: const EdgeInsets.fromLTRB(16, 8, 16, 24),
          sliver: SliverList.list(
            children: [
              if (isLoading) const LinearProgressIndicator(),
              if (errorMessage != null) ...[
                const SizedBox(height: 12),
                _ApiNotice(message: errorMessage!),
              ],
              if (products.isNotEmpty) ...[
                const SizedBox(height: 24),
                Text(
                  'Featured products',
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                const SizedBox(height: 12),
                SizedBox(
                  height: 300,
                  child: ListView.separated(
                    scrollDirection: Axis.horizontal,
                    itemCount: visibleFeatured.length,
                    separatorBuilder: (_, _) => const SizedBox(width: 12),
                    itemBuilder: (context, index) {
                      final product = visibleFeatured[index];

                      return SizedBox(
                        width: 220,
                        child: ProductCard(
                          product: product,
                          onOpen: () => _openProduct(product),
                          onAddToCart: () => _addToCart(product),
                        ),
                      );
                    },
                  ),
                ),
              ],
              const SizedBox(height: 24),
              Row(
                children: [
                  Expanded(
                    child: Text(
                      'All products',
                      style: Theme.of(context).textTheme.titleLarge,
                    ),
                  ),
                  TextButton(
                    onPressed: isLoading ? null : () => _loadProducts(),
                    child: const Text('Reload'),
                  ),
                ],
              ),
              const SizedBox(height: 12),
              if (!isLoading && products.isEmpty)
                const _EmptyProducts()
              else
                ...products.map(
                  (product) => Padding(
                    padding: const EdgeInsets.only(bottom: 12),
                    child: ProductCard(
                      product: product,
                      isCompact: true,
                      onOpen: () => _openProduct(product),
                      onAddToCart: () => _addToCart(product),
                    ),
                  ),
                ),
            ],
          ),
        ),
      ],
    );
  }
}

class _MatgarTitle extends StatelessWidget {
  const _MatgarTitle();

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        Image.asset(
          'assets/images/logo_matgar.png',
          width: 50,
          height: 50,
          fit: BoxFit.contain,
        ),
        const SizedBox(width: 8),
        const Text(
          'Matgar',
          style: TextStyle(
            fontWeight: FontWeight.w700,
            color: Color(0xff0f172a),
          ),
        ),
      ],
    );
  }
}

class _ApiNotice extends StatelessWidget {
  const _ApiNotice({required this.message});

  final String message;

  @override
  Widget build(BuildContext context) {
    return DecoratedBox(
      decoration: BoxDecoration(
        color: Theme.of(context).colorScheme.secondaryContainer,
        borderRadius: BorderRadius.circular(8),
      ),
      child: Padding(
        padding: const EdgeInsets.all(12),
        child: Text(message),
      ),
    );
  }
}

class _EmptyProducts extends StatelessWidget {
  const _EmptyProducts();

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 48),
      child: Column(
        children: [
          Icon(
            Icons.inventory_2_outlined,
            size: 64,
            color: Theme.of(context).colorScheme.primary,
          ),
          const SizedBox(height: 16),
          Text(
            'No products yet',
            style: Theme.of(context).textTheme.titleLarge,
          ),
          const SizedBox(height: 8),
          const Text(
            'Products from the Laravel API will appear here.',
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}
