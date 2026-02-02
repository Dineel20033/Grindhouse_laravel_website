import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:grindhouse_app/screens/cart_provider.dart';
import 'package:grindhouse_app/screens/login_page.dart';
import 'package:grindhouse_app/services/api_service.dart';

class CheckoutPage extends StatefulWidget {
  const CheckoutPage({super.key});

  @override
  State<CheckoutPage> createState() => _CheckoutPageState();
}

class _CheckoutPageState extends State<CheckoutPage> {
  final _formKey = GlobalKey<FormState>();
  final _nameController = TextEditingController();
  final _emailController = TextEditingController();
  final _phoneController = TextEditingController();
  final _addressController = TextEditingController();

  bool _isSubmitting = false;
  String? _errorText;

  @override
  void initState() {
    super.initState();
    final user = ApiService.user;
    _nameController.text = user?['name'] ?? '';
    _emailController.text = user?['email'] ?? '';

    WidgetsBinding.instance.addPostFrameCallback((_) async {
      if (!ApiService.isLoggedIn && mounted) {
        final result = await Navigator.push(
          context,
          MaterialPageRoute(builder: (context) => const LoginPage()),
        );
        if (result != true && mounted) {
          Navigator.pop(context);
        }
      }
    });
  }

  @override
  void dispose() {
    _nameController.dispose();
    _emailController.dispose();
    _phoneController.dispose();
    _addressController.dispose();
    super.dispose();
  }

  double _parsePrice(String priceString) {
    final cleaned = priceString.replaceAll(RegExp(r'[^0-9.]'), '');
    return double.tryParse(cleaned) ?? 0.0;
  }

  String _formatPrice(double price) {
    return "LKR ${price.toStringAsFixed(2).replaceAllMapped(
      RegExp(r'(\d)(?=(\d{3})+(?!\d))'),
      (Match m) => '${m[1]},',
    )}";
  }

  Future<void> _placeOrder(CartProvider cart) async {
    if (!_formKey.currentState!.validate()) {
      return;
    }

    if (cart.items.isEmpty) {
      setState(() {
        _errorText = "Your cart is empty.";
      });
      return;
    }

    setState(() {
      _isSubmitting = true;
      _errorText = null;
    });

    final total = cart.items.fold<double>(0.0, (sum, item) {
      return sum + (_parsePrice(item.product.price) * item.quantity);
    });

    final payload = {
      'customer_name': _nameController.text.trim(),
      'email': _emailController.text.trim(),
      'phone': _phoneController.text.trim().isEmpty ? null : _phoneController.text.trim(),
      'address': _addressController.text.trim(),
      'total': total,
      'items': cart.items
          .map((item) => {
                'product_name': item.product.title,
                'price': _parsePrice(item.product.price),
                'quantity': item.quantity,
              })
          .toList(),
    };

    final result = await ApiService.placeOrder(payload);

    if (!mounted) return;

    if (result != null && result['success'] == true) {
      cart.clearCart();
      setState(() {
        _isSubmitting = false;
      });

      showDialog(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text("Order Placed"),
          content: Text("Your order has been placed successfully. Order ID: #${result['order_id']}."),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.of(context).pop();
                Navigator.of(context).pop();
              },
              child: const Text("OK"),
            ),
          ],
        ),
      );
    } else {
      setState(() {
        _isSubmitting = false;
        _errorText = "Failed to place order. Please try again.";
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;

    return Consumer<CartProvider>(
      builder: (context, cart, child) {
        final total = cart.items.fold<double>(0.0, (sum, item) {
          return sum + (_parsePrice(item.product.price) * item.quantity);
        });

        return Scaffold(
          backgroundColor: isDark ? const Color(0xFF1B1B18) : const Color(0xFFFFFBEB),
          appBar: AppBar(
            backgroundColor: isDark ? const Color(0xFF1B1B18) : const Color(0xFFFFFBEB),
            elevation: 0,
            leading: IconButton(
              icon: Icon(Icons.arrow_back, color: isDark ? Colors.white : const Color(0xFF1F2937)),
              onPressed: () => Navigator.pop(context),
            ),
            title: Text(
              "Finalize Your Order",
              style: TextStyle(
                fontWeight: FontWeight.bold,
                color: isDark ? Colors.white : const Color(0xFF15803D),
              ),
            ),
          ),
          body: SingleChildScrollView(
            padding: const EdgeInsets.all(20),
            child: Column(
              children: [
                Container(
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: isDark ? const Color(0xFF2A2A28) : Colors.white,
                    borderRadius: BorderRadius.circular(16),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withValues(alpha: isDark ? 0.3 : 0.08),
                        blurRadius: 16,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Form(
                    key: _formKey,
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          "Shipping Details",
                          style: TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                            color: isDark ? Colors.white : const Color(0xFF1F2937),
                          ),
                        ),
                        const SizedBox(height: 16),
                        if (_errorText != null) ...[
                          Container(
                            width: double.infinity,
                            padding: const EdgeInsets.all(12),
                            decoration: BoxDecoration(
                              color: const Color(0xFFFEE2E2),
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: Text(
                              _errorText!,
                              style: const TextStyle(color: Color(0xFFB91C1C)),
                            ),
                          ),
                          const SizedBox(height: 12),
                        ],
                        TextFormField(
                          controller: _nameController,
                          decoration: const InputDecoration(
                            hintText: "Full Name",
                            border: OutlineInputBorder(),
                          ),
                          validator: (value) => value == null || value.trim().isEmpty ? "Name is required" : null,
                        ),
                        const SizedBox(height: 12),
                        TextFormField(
                          controller: _emailController,
                          keyboardType: TextInputType.emailAddress,
                          decoration: const InputDecoration(
                            hintText: "Email",
                            border: OutlineInputBorder(),
                          ),
                          validator: (value) => value == null || value.trim().isEmpty ? "Email is required" : null,
                        ),
                        const SizedBox(height: 12),
                        TextFormField(
                          controller: _phoneController,
                          keyboardType: TextInputType.phone,
                          decoration: const InputDecoration(
                            hintText: "Phone Number",
                            border: OutlineInputBorder(),
                          ),
                        ),
                        const SizedBox(height: 12),
                        TextFormField(
                          controller: _addressController,
                          maxLines: 3,
                          decoration: const InputDecoration(
                            hintText: "Shipping Address",
                            border: OutlineInputBorder(),
                          ),
                          validator: (value) => value == null || value.trim().isEmpty ? "Address is required" : null,
                        ),
                        const SizedBox(height: 16),
                        SizedBox(
                          width: double.infinity,
                          height: 52,
                          child: ElevatedButton(
                            onPressed: _isSubmitting ? null : () => _placeOrder(cart),
                            style: ElevatedButton.styleFrom(
                              backgroundColor: const Color(0xFF16A34A),
                              foregroundColor: Colors.white,
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                            ),
                            child: _isSubmitting
                                ? const SizedBox(
                                    height: 22,
                                    width: 22,
                                    child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white),
                                  )
                                : const Text("Place Order", style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
                const SizedBox(height: 24),
                Container(
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: isDark ? const Color(0xFF2A2A28) : Colors.white,
                    borderRadius: BorderRadius.circular(16),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withValues(alpha: isDark ? 0.3 : 0.08),
                        blurRadius: 16,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        "Order Summary",
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: isDark ? Colors.white : const Color(0xFF1F2937),
                        ),
                      ),
                      const SizedBox(height: 12),
                      if (cart.items.isEmpty)
                        Text(
                          "No items in your cart.",
                          style: TextStyle(color: isDark ? Colors.white70 : Colors.black54),
                        )
                      else
                        Column(
                          children: cart.items.map((item) {
                            final lineTotal = _parsePrice(item.product.price) * item.quantity;
                            return Padding(
                              padding: const EdgeInsets.symmetric(vertical: 6),
                              child: Row(
                                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                children: [
                                  Expanded(
                                    child: Text(
                                      "${item.product.title} x${item.quantity}",
                                      style: TextStyle(color: isDark ? Colors.white70 : const Color(0xFF374151)),
                                      overflow: TextOverflow.ellipsis,
                                    ),
                                  ),
                                  Text(
                                    _formatPrice(lineTotal),
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                      color: isDark ? Colors.white : const Color(0xFF1F2937),
                                    ),
                                  ),
                                ],
                              ),
                            );
                          }).toList(),
                        ),
                      const Divider(height: 24),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text(
                            "Total",
                            style: TextStyle(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                              color: isDark ? Colors.white : const Color(0xFF1F2937),
                            ),
                          ),
                          Text(
                            _formatPrice(total),
                            style: const TextStyle(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                              color: Color(0xFFB45309),
                            ),
                          ),
                        ],
                      ),
                    ],
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