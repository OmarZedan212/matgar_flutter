import 'package:flutter/material.dart';

import '../models/customer_order.dart';
import '../services/order_service.dart';

class OrderDetailScreen extends StatefulWidget {
  const OrderDetailScreen({
    super.key,
    required this.initialOrder,
    required this.orderService,
  });

  final CustomerOrder initialOrder;
  final OrderService orderService;

  @override
  State<OrderDetailScreen> createState() => _OrderDetailScreenState();
}

class _OrderDetailScreenState extends State<OrderDetailScreen> {
  late CustomerOrder order = widget.initialOrder;
  bool isLoading = true;
  String? errorMessage;

  @override
  void initState() {
    super.initState();
    _loadOrder();
  }

  Future<void> _loadOrder() async {
    setState(() {
      isLoading = true;
      errorMessage = null;
    });

    try {
      final loadedOrder = await widget.orderService.fetchOrder(order.id);

      if (!mounted) {
        return;
      }

      setState(() => order = loadedOrder);
    } catch (_) {
      if (!mounted) {
        return;
      }

      setState(() => errorMessage = 'Could not load order details.');
    } finally {
      if (mounted) {
        setState(() => isLoading = false);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Order #${order.id}')),
      body: RefreshIndicator(
        onRefresh: _loadOrder,
        child: ListView(
          padding: const EdgeInsets.all(16),
          children: [
            if (isLoading) const LinearProgressIndicator(),
            if (errorMessage != null) ...[
              const SizedBox(height: 12),
              Text(
                errorMessage!,
                style: TextStyle(color: Theme.of(context).colorScheme.error),
              ),
            ],
            Card(
              margin: const EdgeInsets.only(top: 12),
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _InfoRow(label: 'Order ID', value: '#${order.id}'),
                    _InfoRow(label: 'Date', value: order.dateLabel),
                    _InfoRow(label: 'Status', value: order.status),
                    _InfoRow(
                      label: 'Total',
                      value: '\$${order.total.toStringAsFixed(2)}',
                    ),
                    _InfoRow(label: 'Name', value: order.name),
                    _InfoRow(label: 'Phone', value: order.phone),
                    _InfoRow(label: 'Address', value: order.address),
                  ],
                ),
              ),
            ),
            const SizedBox(height: 20),
            Text(
              'Items',
              style: Theme.of(context).textTheme.titleLarge,
            ),
            const SizedBox(height: 12),
            if (order.items.isEmpty)
              const Text('No item details found for this order.')
            else
              ...order.items.map(
                (item) => Card(
                  margin: const EdgeInsets.only(bottom: 12),
                  child: ListTile(
                    title: Text(item.product?.name ?? 'Product #${item.productId}'),
                    subtitle: Text(
                      '${item.quantity} x \$${item.price.toStringAsFixed(2)}',
                    ),
                    trailing: Text(
                      '\$${item.lineTotal.toStringAsFixed(2)}',
                      style: const TextStyle(fontWeight: FontWeight.w700),
                    ),
                  ),
                ),
              ),
          ],
        ),
      ),
    );
  }
}

class _InfoRow extends StatelessWidget {
  const _InfoRow({
    required this.label,
    required this.value,
  });

  final String label;
  final String value;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 10),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 88,
            child: Text(
              label,
              style: const TextStyle(fontWeight: FontWeight.w700),
            ),
          ),
          Expanded(child: Text(value.isEmpty ? '-' : value)),
        ],
      ),
    );
  }
}
