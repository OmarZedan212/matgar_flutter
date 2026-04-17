import 'package:flutter/material.dart';

import '../state/cart_controller.dart';

class CartScreen extends StatelessWidget {
  const CartScreen({
    super.key,
    required this.cart,
  });

  final CartController cart;

  @override
  Widget build(BuildContext context) {
    return ListenableBuilder(
      listenable: cart,
      builder: (context, _) {
        return Scaffold(
          appBar: AppBar(
            title: const Text('Cart'),
            actions: [
              if (cart.lines.isNotEmpty)
                TextButton(
                  onPressed: cart.clear,
                  child: const Text('Clear'),
                ),
            ],
          ),
          body: cart.lines.isEmpty
              ? const _EmptyCart()
              : ListView.separated(
                  padding: const EdgeInsets.all(16),
                  itemCount: cart.lines.length,
                  separatorBuilder: (_, _) => const SizedBox(height: 12),
                  itemBuilder: (context, index) {
                    final line = cart.lines[index];
                    return Card(
                      margin: EdgeInsets.zero,
                      child: ListTile(
                        title: Text(line.product.name),
                        subtitle: Text(
                          '${line.quantity} x \$${line.product.price.toStringAsFixed(2)}',
                        ),
                        trailing: IconButton(
                          tooltip: 'Remove one',
                          onPressed: () => cart.remove(line.product),
                          icon: const Icon(Icons.remove_circle_outline),
                        ),
                      ),
                    );
                  },
                ),
          bottomNavigationBar: cart.lines.isEmpty
              ? null
              : Padding(
                  padding: const EdgeInsets.all(16),
                  child: FilledButton(
                    onPressed: () {},
                    child: Text(
                      'Checkout - \$${cart.subtotal.toStringAsFixed(2)}',
                    ),
                  ),
                ),
        );
      },
    );
  }
}

class _EmptyCart extends StatelessWidget {
  const _EmptyCart();

  @override
  Widget build(BuildContext context) {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(32),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(
              Icons.shopping_bag_outlined,
              size: 64,
              color: Theme.of(context).colorScheme.primary,
            ),
            const SizedBox(height: 16),
            Text(
              'Your cart is empty',
              style: Theme.of(context).textTheme.titleLarge,
            ),
            const SizedBox(height: 8),
            const Text(
              'Add products from the shop and they will appear here.',
              textAlign: TextAlign.center,
            ),
          ],
        ),
      ),
    );
  }
}
