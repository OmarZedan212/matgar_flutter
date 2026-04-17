import 'dart:convert';

import 'package:http/http.dart' as http;

import '../config/api_config.dart';

class ApiClient {
  ApiClient({http.Client? client}) : _client = client ?? http.Client();

  final http.Client _client;
  String? authToken;

  Future<dynamic> get(
    String path, {
    Map<String, String>? queryParameters,
  }) {
    return _send(
      _client.get(
        ApiConfig.endpoint(path, queryParameters: queryParameters),
        headers: _headers(),
      ),
    );
  }

  Future<dynamic> post(String path, {Map<String, dynamic>? body}) {
    return _send(
      _client.post(
        ApiConfig.endpoint(path),
        headers: _headers(),
        body: jsonEncode(body ?? {}),
      ),
    );
  }

  Future<dynamic> put(String path, {Map<String, dynamic>? body}) {
    return _send(
      _client.put(
        ApiConfig.endpoint(path),
        headers: _headers(),
        body: jsonEncode(body ?? {}),
      ),
    );
  }

  Future<dynamic> delete(String path) {
    return _send(
      _client.delete(
        ApiConfig.endpoint(path),
        headers: _headers(),
      ),
    );
  }

  void close() {
    _client.close();
  }

  Map<String, String> _headers() {
    return {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      if (authToken != null) 'Authorization': 'Bearer $authToken',
    };
  }

  Future<dynamic> _send(Future<http.Response> request) async {
    final response = await request;
    final body = utf8.decode(response.bodyBytes);
    final decoded = body.isEmpty ? null : jsonDecode(body);

    if (response.statusCode >= 200 && response.statusCode < 300) {
      return decoded;
    }

    final message = decoded is Map<String, dynamic>
        ? decoded['message'] as String? ?? 'Request failed.'
        : 'Request failed.';
    throw ApiException(message, response.statusCode);
  }
}

class ApiException implements Exception {
  const ApiException(this.message, this.statusCode);

  final String message;
  final int statusCode;

  @override
  String toString() => message;
}
