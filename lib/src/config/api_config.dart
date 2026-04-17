class ApiConfig {
  const ApiConfig._();

  static const String baseUrl = String.fromEnvironment(
    'LARAVEL_API_BASE_URL',
    defaultValue: 'http://127.0.0.1:8000/api/mobile',
  );
  static Uri endpoint(String path, {Map<String, String>? queryParameters}) {
    final normalizedBaseUrl = baseUrl.endsWith('/')
        ? baseUrl.substring(0, baseUrl.length - 1)
        : baseUrl;
    final normalizedPath = path.startsWith('/') ? path.substring(1) : path;

    return Uri.parse(
      '$normalizedBaseUrl/$normalizedPath',
    ).replace(queryParameters: queryParameters);
  }
}
