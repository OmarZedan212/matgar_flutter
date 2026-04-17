import '../models/customer_order.dart';
import 'api_client.dart';

class OrderService {
  const OrderService(this._client);

  final ApiClient _client;

  Future<List<CustomerOrder>> fetchOrders() async {
    final response = await _client.get('/orders') as Map<String, dynamic>;
    final data = response['data'] as List<dynamic>? ?? const [];

    return data
        .whereType<Map<String, dynamic>>()
        .map(CustomerOrder.fromJson)
        .toList(growable: false);
  }

  Future<CustomerOrder> fetchOrder(int orderId) async {
    final response = await _client.get('/orders/$orderId') as Map<String, dynamic>;

    return CustomerOrder.fromJson(response['data'] as Map<String, dynamic>);
  }
}
