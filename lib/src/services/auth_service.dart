import '../models/app_user.dart';
import 'api_client.dart';

class AuthService {
  const AuthService(this._client);

  final ApiClient _client;

  Future<AuthSession> login({
    required String email,
    required String password,
  }) async {
    final response = await _client.post('/login', body: {
      'email': email,
      'password': password,
    }) as Map<String, dynamic>;

    return AuthSession.fromJson(response);
  }

  Future<AuthSession> register({
    required String name,
    required String email,
    required String password,
  }) async {
    final response = await _client.post('/register', body: {
      'name': name,
      'email': email,
      'password': password,
      'password_confirmation': password,
    }) as Map<String, dynamic>;

    return AuthSession.fromJson(response);
  }

  Future<void> logout() async {
    await _client.post('/logout');
  }
}

class AuthSession {
  const AuthSession({
    required this.token,
    required this.user,
  });

  final String token;
  final AppUser user;

  factory AuthSession.fromJson(Map<String, dynamic> json) {
    return AuthSession(
      token: json['token'] as String,
      user: AppUser.fromJson(json['user'] as Map<String, dynamic>),
    );
  }
}
