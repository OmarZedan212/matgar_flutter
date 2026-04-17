import 'package:flutter/material.dart';

import '../state/cart_controller.dart';

class CartScreen extends StatelessWidget {
  const CartScreen({
    super.key,
    required this.cart,
  });

  final CartController cart;

  Future<void> _showResult(
    BuildContext context,
    Future<bool> Function() action,
  ) async {
    final ok = await action();

    if (!context.mounted) {
      return;
    }

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          ok
              ? cart.successMessage ?? 'Cart updated.'
              : cart.errorMessage ?? 'Cart update failed.',
        ),
      ),
    );
  }

  void _openCheckout(BuildContext context) {
    showModalBottomSheet<void>(
      context: context,
      isScrollControlled: true,
      builder: (_) => _CheckoutSheet(cart: cart),
    );
  }

  @override
  Widget build(BuildContext context) {
    return ListenableBuilder(
      listenable: cart,
      builder: (context, _) {
        return Scaffold(
          appBar: AppBar(
            title: const Text('Cart'),
            actions: [
              if (cart.isSignedIn)
                IconButton(
                  tooltip: 'Refresh cart',
                  onPressed: cart.isLoading ? null : cart.load,
                  icon: const Icon(Icons.refresh),
                ),
              if (cart.lines.isNotEmpty)
                TextButton(
                  onPressed: cart.isLoading
                      ? null
                      : () => _showResult(context, cart.clear),
                  child: const Text('Clear'),
                ),
            ],
          ),
          body: !cart.isSignedIn
              ? const _CartMessage(
                  icon: Icons.lock_outline,
                  title: 'Sign in to use your cart',
                  message: 'Your cart is saved in the Laravel database after you sign in.',
                )
              : cart.isLoading && cart.lines.isEmpty
                  ? const Center(child: CircularProgressIndicator())
                  : cart.lines.isEmpty
                      ? const _EmptyCart()
                      : ListView.separated(
                  padding: const EdgeInsets.all(16),
                  itemCount: cart.lines.length,
                  separatorBuilder: (_, _) => const SizedBox(height: 12),
                  itemBuilder: (context, index) {
                    final line = cart.lines[index];
                    final product = line.product!;

                    return Card(
                      margin: EdgeInsets.zero,
                      child: Padding(
                        padding: const EdgeInsets.all(12),
                        child: Row(
                          children: [
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(
                                    product.name,
                                    style: Theme.of(context).textTheme.titleMedium,
                                  ),
                                  const SizedBox(height: 4),
                                  Text(
                                    '${line.quantity} x \$${line.price.toStringAsFixed(2)}',
                                  ),
                                  const SizedBox(height: 4),
                                  Text(
                                    'Subtotal: \$${line.lineTotal.toStringAsFixed(2)}',
                                    style: const TextStyle(fontWeight: FontWeight.w700),
                                  ),
                                ],
                              ),
                            ),
                            IconButton(
                              tooltip: 'Decrease',
                              onPressed: cart.isLoading
                                  ? null
                                  : () => _showResult(
                                        context,
                                        () => cart.decrease(line),
                                      ),
                              icon: const Icon(Icons.remove_circle_outline),
                            ),
                            Text('${line.quantity}'),
                            IconButton(
                              tooltip: 'Increase',
                              onPressed: cart.isLoading
                                  ? null
                                  : () => _showResult(
                                        context,
                                        () => cart.increase(line),
                                      ),
                              icon: const Icon(Icons.add_circle_outline),
                            ),
                            IconButton(
                              tooltip: 'Remove',
                              onPressed: cart.isLoading
                                  ? null
                                  : () => _showResult(
                                        context,
                                        () => cart.remove(line),
                                      ),
                              icon: const Icon(Icons.delete_outline),
                            ),
                          ],
                        ),
                      ),
                    );
                  },
                ),
          bottomNavigationBar: !cart.isSignedIn || cart.lines.isEmpty
              ? null
              : Padding(
                  padding: const EdgeInsets.all(16),
                  child: SafeArea(
                    child: FilledButton(
                      onPressed: cart.isLoading ? null : () => _openCheckout(context),
                      child: Text(
                        'Checkout - \$${cart.subtotal.toStringAsFixed(2)}',
                      ),
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
    return const _CartMessage(
      icon: Icons.shopping_bag_outlined,
      title: 'Your cart is empty',
      message: 'Add products from the shop and they will appear here.',
    );
  }
}

class _CartMessage extends StatelessWidget {
  const _CartMessage({
    required this.icon,
    required this.title,
    required this.message,
  });

  final IconData icon;
  final String title;
  final String message;

  @override
  Widget build(BuildContext context) {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(32),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(
              icon,
              size: 64,
              color: Theme.of(context).colorScheme.primary,
            ),
            const SizedBox(height: 16),
            Text(
              title,
              style: Theme.of(context).textTheme.titleLarge,
            ),
            const SizedBox(height: 8),
            Text(
              message,
              textAlign: TextAlign.center,
            ),
          ],
        ),
      ),
    );
  }
}

class _CheckoutSheet extends StatefulWidget {
  const _CheckoutSheet({required this.cart});

  final CartController cart;

  @override
  State<_CheckoutSheet> createState() => _CheckoutSheetState();
}

class _CheckoutSheetState extends State<_CheckoutSheet> {
  late final nameController = TextEditingController(
    text: widget.cart.user?.name ?? '',
  );
  late final emailController = TextEditingController(
    text: widget.cart.user?.email ?? '',
  );
  late final phoneController = TextEditingController(
    text: widget.cart.user?.phone ?? '',
  );
  late final addressController = TextEditingController(
    text: widget.cart.user?.address ?? '',
  );

  @override
  void dispose() {
    nameController.dispose();
    emailController.dispose();
    phoneController.dispose();
    addressController.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    final ok = await widget.cart.checkout(
      name: nameController.text.trim(),
      email: emailController.text.trim(),
      phone: phoneController.text.trim(),
      address: addressController.text.trim(),
    );

    if (!mounted) {
      return;
    }

    Navigator.of(context).pop();
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          ok
              ? widget.cart.successMessage ?? 'Order placed successfully.'
              : widget.cart.errorMessage ?? 'Checkout failed.',
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final bottom = MediaQuery.of(context).viewInsets.bottom;

    return Padding(
      padding: EdgeInsets.fromLTRB(16, 16, 16, bottom + 16),
      child: ListView(
        shrinkWrap: true,
        children: [
          Text(
            'Checkout',
            style: Theme.of(context).textTheme.headlineSmall,
          ),
          const SizedBox(height: 12),
          TextField(
            controller: nameController,
            decoration: const InputDecoration(
              border: OutlineInputBorder(),
              labelText: 'Full name',
            ),
          ),
          const SizedBox(height: 12),
          TextField(
            controller: emailController,
            keyboardType: TextInputType.emailAddress,
            decoration: const InputDecoration(
              border: OutlineInputBorder(),
              labelText: 'Email',
            ),
          ),
          const SizedBox(height: 12),
          TextField(
            controller: phoneController,
            keyboardType: TextInputType.phone,
            decoration: const InputDecoration(
              border: OutlineInputBorder(),
              labelText: 'Phone',
            ),
          ),
          const SizedBox(height: 12),
          TextField(
            controller: addressController,
            maxLines: 3,
            decoration: const InputDecoration(
              border: OutlineInputBorder(),
              labelText: 'Address',
            ),
          ),
          const SizedBox(height: 16),
          FilledButton(
            onPressed: widget.cart.isLoading ? null : _submit,
            child: const Text('Confirm order'),
          ),
        ],
      ),
    );
  }
}
