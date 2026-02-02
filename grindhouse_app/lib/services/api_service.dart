import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  // Use 10.0.2.2 for Android Emulator to access localhost
  // Use your computer's IP address if testing on a physical device
  static const String baseUrl = String.fromEnvironment(
    'API_BASE_URL',
    defaultValue: 'https://grindhouselaravelwebsite-production.up.railway.app/api',
  );

  static const String assetBaseUrl = String.fromEnvironment(
    'ASSET_BASE_URL',
    defaultValue: 'https://grindhouselaravelwebsite-production.up.railway.app',
  );

  static String? _token;
  static Map<String, dynamic>? _user;

  static void setToken(String token) {
    _token = token;
  }

  static bool get isLoggedIn => _token != null;
  static Map<String, dynamic>? get user => _user;

  static Future<void> logout() async {
    if (_token != null) {
      try {
        await post('/logout', {});
      } catch (e) {
        print('Logout error: $e');
      }
    }
    _token = null;
    _user = null;
  }

  static Map<String, String> get _headers => {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        if (_token != null) 'Authorization': 'Bearer $_token',
      };

  static Future<http.Response> post(String endpoint, Map<String, dynamic> data) async {
    final response = await http.post(
      Uri.parse('$baseUrl$endpoint'),
      headers: _headers,
      body: jsonEncode(data),
    );
    return response;
  }

  static Future<http.Response> get(String endpoint) async {
    final response = await http.get(
      Uri.parse('$baseUrl$endpoint'),
      headers: _headers,
    );
    return response;
  }

  static Future<Map<String, dynamic>?> login(String email, String password) async {
    try {
      final response = await post('/login', {
        'email': email,
        'password': password,
      });

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        _token = data['token'];
        if (data['user'] != null) {
          _user = data['user'];
        } else if (data['data'] != null && data['data']['user'] != null) {
          _user = data['data']['user'];
        } else {
          // Fallback if structure is different
          _user = data; 
        }
        return data;
      } else {
        return null;
      }
    } catch (e) {
      print('Login error: $e');
      return null;
    }
  }

  static Future<Map<String, dynamic>?> register(String name, String email, String password, String passwordConfirmation) async {
    try {
      final response = await post('/register', {
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': passwordConfirmation,
      });

      if (response.statusCode == 201) {
        final data = jsonDecode(response.body);
        _token = data['token'];
        if (data['user'] != null) {
          _user = data['user'];
        } else if (data['data'] != null && data['data']['user'] != null) {
          _user = data['data']['user'];
        } else {
          _user = data;
        }
        return data;
      } else {
        return null;
      }
    } catch (e) {
      print('Register error: $e');
      return null;
    }
  }

  static Future<List<dynamic>?> getProducts() async {
    try {
      final response = await get('/products');
      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return data['data'];
      }
      return null;
    } catch (e) {
      print('Get products error: $e');
      return null;
    }
  }

  static Future<List<dynamic>?> getCategories() async {
    try {
      final response = await get('/categories');
      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return data['data'];
      }
      return null;
    } catch (e) {
      print('Get categories error: $e');
      return null;
    }
  }

  static Future<Map<String, dynamic>?> updateProfile(String name, String email) async {
    try {
      final response = await post('/user/update', {
        'name': name,
        'email': email,
      });

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['user'] != null) {
          _user = data['user'];
        }
        return data;
      }
      return null;
    } catch (e) {
      print('Update profile error: $e');
      return null;
    }
  }

  static Future<Map<String, dynamic>?> updatePassword(String current, String password, String confirmation) async {
    try {
      final response = await post('/user/password', {
        'current_password': current,
        'password': password,
        'password_confirmation': confirmation,
      });

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      }
      return null;
    } catch (e) {
      print('Update password error: $e');
      return null;
    }
  }

  static Future<bool> deleteAccount() async {
    try {
      final response = await post('/user/delete', {});
      if (response.statusCode == 200) {
        logout();
        return true;
      }
      return false;
    } catch (e) {
      print('Delete account error: $e');
      return false;
    }
  }

  static Future<List<dynamic>?> getOrderHistory() async {
    try {
      final response = await get('/orders');
      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return data['data'];
      }
      return null;
    } catch (e) {
      print('Get order history error: $e');
      return null;
    }
  }

  static Future<Map<String, dynamic>?> placeOrder(Map<String, dynamic> payload) async {
    try {
      final response = await post('/checkout', payload);
      if (response.statusCode == 201 || response.statusCode == 200) {
        return jsonDecode(response.body);
      }
      return null;
    } catch (e) {
      print('Place order error: $e');
      return null;
    }
  }

  static Future<Map<String, dynamic>?> sendContactMessage(Map<String, dynamic> payload) async {
    try {
      final response = await post('/contact', payload);
      if (response.statusCode == 201 || response.statusCode == 200) {
        return jsonDecode(response.body);
      }
      return null;
    } catch (e) {
      print('Send contact error: $e');
      return null;
    }
  }

  static String getAssetUrl(String? path) {
    if (path == null || path.isEmpty) return '';
    if (path.startsWith('http')) return path;

    // Remove leading slash if present
    final cleanPath = path.startsWith('/') ? path.substring(1) : path;
    return '$assetBaseUrl/$cleanPath';
  }

  static String getImageUrl(String? path) {
    return getAssetUrl(path);
  }
}
