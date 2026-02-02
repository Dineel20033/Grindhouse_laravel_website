import 'package:grindhouse_app/screens/product_model.dart';

class CartItem {
  final Product product;
  int quantity;

  CartItem({
    required this.product,
    required this.quantity,
  });

  double get totalPrice {
    // Extract numeric value from price string (e.g., "LKR 55,000" -> 55000)
    final priceString = product.price.replaceAll(RegExp(r'[^0-9]'), '');
    final price = double.tryParse(priceString) ?? 0;
    return price * quantity;
  }
}