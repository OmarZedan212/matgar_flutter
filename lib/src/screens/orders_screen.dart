import 'package:flutter/material.dart';

import '../models/customer_order.dart';
import '../services/order_service.dart';
import '../state/session_controller.dart';
import 'order_detail_screen.dart';

class OrdersScreen extends StatefulWidget {
  const OrdersScreen({
    super.key,
    required this.orderService,
    required this.session,
  });

  final OrderService orderService;
  final SessionController session;

  @override
  State<OrdersScreen> createState() => _OrdersScreenState();
}

class _OrdersScreenState extends State<OrdersScreen> {
  var orders = <CustomerOrder>[];
  bool isLoading = false;
  String? errorMessage;
  bool wasSignedIn = false;

  @override
  void initState() {
    super.initState();
    wasSignedIn = widget.session.isSignedIn;
    widget.session.addListener(_handleSessionChanged);

    if (wasSignedIn) {
      _loadOrders();
    }
  }

  @override
  void dispose() {
    widget.session.removeListener(_handleSessionChanged);
    super.dispose();
  }

  void _handleSessionChanged() {
    final signedIn = widget.session.isSignedIn;

    if (signedIn && !wasSignedIn) {
      wasSignedIn = true;
      _loadOrders();
      return;
    }

    if (!signedIn && wasSignedIn) {
      wasSignedIn = false;
      setState(() {
        orders = [];
        errorMessage = null;
      });
    }
  }

  Future<void> _loadOrders() async {
    if (!widget.session.isSignedIn) {
      return;
    }

    setState(() {
      isLoading = true;
      errorMessage = null;
    });

    try {
      final loadedOrders = await widget.orderService.fetchOrders();

      if (!mounted) {
        return;
      }

      setState(() => orders = loadedOrders);
    } catch (_) {
      if (!mounted) {
        return;
      }

      setState(() {
        orders = [];
        errorMessage = 'Could not load your orders.';
      });
    } finally {
      if (mounted) {
        setState(() => isLoading = false);
      }
    }
  }

  void _openOrder(CustomerOrder order) {
    Navigator.of(context).push(
      MaterialPageRoute(
        builder: (_) => OrderDetailScreen(
          initialOrder: order,
          orderService: widget.orderService,
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return ListenableBuilder(
      listenable: widget.session,
      builder: (context, _) {
        return Scaffold(
          appBar: AppBar(
            title: const Text('Orders'),
            actions: [
              if (widget.session.isSignedIn)
                IconButton(
                  tooltip: 'Refresh orders',
                  onPressed: isLoading ? null : _loadOrders,
                  icon: const Icon(Icons.refresh),
                ),
            ],
          ),
          body: !widget.session.isSignedIn
              ? const _OrdersMessage(
                  icon: Icons.lock_outline,
                  title: 'Sign in to track orders',
                  message: 'Your order history is linked to your customer account.',
                )
              : RefreshIndicator(
                  onRefresh: _loadOrders,
                  child: ListView(
                    padding: const EdgeInsets.all(16),
                    children: [
                      if (isLoading) const LinearProgressIndicator(),
                      if (errorMessage != null) ...[
                        const SizedBox(height: 12),
                        Text(
                          errorMessage!,
                          style: TextStyle(
                            color: Theme.of(context).colorScheme.error,
                          ),
                        ),
                      ],
                      if (!isLoading && orders.isEmpty && errorMessage == null)
                        const _OrdersMessage(
                          icon: Icons.receipt_long_outlined,
                          title: 'No orders yet',
                          message: 'Orders you place from checkout will appear here.',
                        )
                      else
                        ...orders.map(
                          (order) => Card(
                            margin: const EdgeInsets.only(bottom: 12),
                            child: ListTile(
                              title: Text('Order #${order.id}'),
                              subtitle: Text(
                                '${order.dateLabel} - ${order.status}',
                              ),
                              trailing: Column(
                                mainAxisAlignment: MainAxisAlignment.center,
                                crossAxisAlignment: CrossAxisAlignment.end,
                                children: [
                                  Text(
                                    '\$${order.total.toStringAsFixed(2)}',
                                    style: const TextStyle(
                                      fontWeight: FontWeight.w700,
                                    ),
                                  ),
                                  const Text('View'),
                                ],
                              ),
                              onTap: () => _openOrder(order),
                            ),
                          ),
                        ),
                    ],
                  ),
                ),
        );
      },
    );
  }
}

class _OrdersMessage extends StatelessWidget {
  const _OrdersMessage({
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
