import 'package:flutter/foundation.dart';

import '../models/app_user.dart';
import '../services/api_client.dart';
import '../services/auth_service.dart';

class SessionController extends ChangeNotifier {
  SessionController({
    required ApiClient apiClient,
    required AuthService authService,
  })  : _apiClient = apiClient,
        _authService = authService;

  final ApiClient _apiClient;
  final AuthService _authService;

  AppUser? user;
  bool isLoading = false;
  String? errorMessage;

  bool get isSignedIn => user != null && _apiClient.authToken != null;

  Future<void> login({
    required String email,
    required String password,
  }) async {
    await _authenticate(
      () => _authService.login(email: email, password: password),
    );
  }

  Future<void> register({
    required String name,
    required String email,
    required String password,
  }) async {
    await _authenticate(
      () => _authService.register(
        name: name,
        email: email,
        password: password,
      ),
    );
  }

  Future<void> logout() async {
    isLoading = true;
    notifyListeners();

    try {
      await _authService.logout();
    } catch (_) {
      // The local session should still be cleared if the token is expired.
    }

    _apiClient.authToken = null;
    user = null;
    isLoading = false;
    errorMessage = null;
    notifyListeners();
  }

  Future<void> _authenticate(Future<AuthSession> Function() action) async {
    isLoading = true;
    errorMessage = null;
    notifyListeners();

    try {
      final session = await action();
      _apiClient.authToken = session.token;
      user = session.user;
    } on ApiException catch (error) {
      errorMessage = error.message;
    } catch (_) {
      errorMessage = 'Could not reach the Laravel API.';
    } finally {
      isLoading = false;
      notifyListeners();
    }
  }
}
