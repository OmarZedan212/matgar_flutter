import 'package:flutter/material.dart';

import '../models/product.dart';
import '../services/product_service.dart';
import '../state/cart_controller.dart';
import '../widgets/product_card.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({
    super.key,
    required this.initialProducts,
    required this.productService,
    required this.cart,
  });

  final List<Product> initialProducts;
  final ProductService productService;
  final CartController cart;

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  late List<Product> products = widget.initialProducts;
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
        products = remoteProducts.isEmpty
            ? widget.initialProducts
            : remoteProducts;
      });
    } catch (_) {
      if (!mounted) {
        return;
      }

      setState(() {
        products = widget.initialProducts;
        errorMessage = 'Using sample products until the Laravel API is reachable.';
      });
    } finally {
      if (mounted) {
        setState(() => isLoading = false);
      }
    }
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
          title: const Text('Matgar'),
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
              const _HeroBanner(),
              const SizedBox(height: 16),
              if (isLoading) const LinearProgressIndicator(),
              if (errorMessage != null) ...[
                const SizedBox(height: 12),
                _ApiNotice(message: errorMessage!),
              ],
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
                        onAddToCart: () => widget.cart.add(product),
                      ),
                    );
                  },
                ),
              ),
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
              ...products.map(
                (product) => Padding(
                  padding: const EdgeInsets.only(bottom: 12),
                  child: ProductCard(
                    product: product,
                    isCompact: true,
                    onAddToCart: () => widget.cart.add(product),
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

class _HeroBanner extends StatelessWidget {
  const _HeroBanner();

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Theme.of(context).colorScheme.primaryContainer,
        borderRadius: BorderRadius.circular(8),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Fresh picks for your store',
            style: Theme.of(context).textTheme.headlineSmall?.copyWith(
              fontWeight: FontWeight.w700,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'Connect your Laravel products, customers, carts, and orders.',
            style: Theme.of(context).textTheme.bodyLarge,
          ),
          const SizedBox(height: 16),
          FilledButton.icon(
            onPressed: () {},
            icon: const Icon(Icons.shopping_cart_checkout),
            label: const Text('Start shopping'),
          ),
        ],
      ),
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
