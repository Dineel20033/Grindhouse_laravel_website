import 'package:flutter/material.dart';
import 'package:grindhouse_app/screens/product_model.dart';
import 'package:grindhouse_app/screens/cart_item.dart';

class CartProvider extends ChangeNotifier {
  final List<CartItem> _items = [];

  List<CartItem> get items => _items;

  int get itemCount => _items.length;

  int get totalQuantity {
    return _items.fold(0, (sum, item) => sum + item.quantity);
  }

  double get totalAmount {
    return _items.fold(0.0, (sum, item) => sum + item.totalPrice);
  }

  void addToCart(Product product, int quantity) {
    // Check if product already exists in cart
    final existingIndex = _items.indexWhere(
      (item) => item.product.title == product.title,
    );

    if (existingIndex >= 0) {
      // Update quantity if product exists
      _items[existingIndex].quantity += quantity;
    } else {
      // Add new item to cart
      _items.add(CartItem(product: product, quantity: quantity));
    }
    notifyListeners();
  }

  void removeFromCart(Product product) {
    _items.removeWhere((item) => item.product.title == product.title);
    notifyListeners();
  }

  void updateQuantity(Product product, int newQuantity) {
    final index = _items.indexWhere(
      (item) => item.product.title == product.title,
    );

    if (index >= 0) {
      if (newQuantity > 0) {
        _items[index].quantity = newQuantity;
      } else {
        _items.removeAt(index);
      }
      notifyListeners();
    }
  }

  void clearCart() {
    _items.clear();
    notifyListeners();
  }

  bool isInCart(Product product) {
    return _items.any((item) => item.product.title == product.title);
  }

  int getQuantity(Product product) {
    final item = _items.firstWhere(
      (item) => item.product.title == product.title,
      orElse: () => CartItem(product: product, quantity: 0),
    );
    return item.quantity;
  }
}