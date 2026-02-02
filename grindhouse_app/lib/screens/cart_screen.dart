import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:grindhouse_app/screens/cart_provider.dart';
import 'package:grindhouse_app/screens/products_details.dart';
import 'package:grindhouse_app/screens/checkout_page.dart';
import 'package:grindhouse_app/screens/login_page.dart';
import 'package:grindhouse_app/services/api_service.dart';
import 'package:grindhouse_app/components/footer.dart';

class CartScreen extends StatelessWidget {
  const CartScreen({super.key});

  String _formatPrice(double price) {
    return "LKR ${price.toStringAsFixed(2).replaceAllMapped(
      RegExp(r'(\d)(?=(\d{3})+(?!\d))'),
      (Match m) => '${m[1]},',
    )}";
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    
    return Scaffold(
      backgroundColor: isDark ? const Color(0xFF1B1B18) : Colors.white,
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        toolbarHeight: 80,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Color(0xFF1F2937)),
          onPressed: () => Navigator.pop(context),
        ),
        titleSpacing: 0,
        title: Image.asset(
          'assets/images/logo.png',
          height: 40,
          fit: BoxFit.contain,
        ),
        actions: [
          if (ApiService.isLoggedIn)
            PopupMenuButton<String>(
              onSelected: (value) async {
                if (value == 'profile') {
                  // If we are pushed, we might need to pop and tell wrapper to change tab
                  // But for now, we can just navigate or pop
                  Navigator.pop(context); // Go back to wrapper
                  // We'd need a way to tell Wrapper to select tab 3
                  // Assuming user can find their way
                } else if (value == 'logout') {
                  await ApiService.logout();
                  Navigator.of(context).popUntil((route) => route.isFirst);
                  ScaffoldMessenger.of(context).showSnackBar(
                    const SnackBar(
                      content: Text("Logged out successfully"),
                      backgroundColor: Color(0xFFFFBF00),
                    ),
                  );
                }
              },
              offset: const Offset(0, 45),
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              itemBuilder: (context) => [
                const PopupMenuItem(
                  value: 'profile',
                  child: Row(
                    children: [
                      Icon(Icons.person_outline, size: 20, color: Color(0xFF92400E)),
                      SizedBox(width: 12),
                      Text('Profile'),
                    ],
                  ),
                ),
                const PopupMenuItem(
                  value: 'logout',
                  child: Row(
                    children: [
                      Icon(Icons.logout, size: 20, color: Colors.red),
                      SizedBox(width: 12),
                      Text('Logout', style: TextStyle(color: Colors.red)),
                    ],
                  ),
                ),
              ],
              child: Center(
                child: Row(
                  children: [
                    const Icon(Icons.account_circle, color: Color(0xFF92400E), size: 30),
                    const SizedBox(width: 8),
                    Text(
                      ApiService.user?['name'] ?? "User",
                      style: const TextStyle(
                        color: Color(0xFF1B1B18),
                        fontWeight: FontWeight.w500,
                        fontSize: 14,
                      ),
                    ),
                    const Icon(
                      Icons.keyboard_arrow_down,
                      color: Colors.grey,
                      size: 20,
                    ),
                    const SizedBox(width: 12),
                  ],
                ),
              ),
            )
          else
            GestureDetector(
              onTap: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => const LoginPage()),
                );
              },
              child: const Row(
                children: [
                  Icon(Icons.account_circle, color: Color(0xFF92400E), size: 30),
                  SizedBox(width: 8),
                  Text(
                    "Sign In",
                    style: TextStyle(
                      color: Color(0xFF1B1B18),
                      fontWeight: FontWeight.w500,
                      fontSize: 14,
                    ),
                  ),
                  Icon(
                    Icons.keyboard_arrow_down,
                    color: Colors.grey,
                    size: 20,
                  ),
                  SizedBox(width: 12),
                ],
              ),
            ),
          Consumer<CartProvider>(
            builder: (context, cart, child) {
              return Stack(
                alignment: Alignment.center,
                children: [
                  const IconButton(
                    onPressed: null, // Already on cart screen
                    icon: Icon(
                      Icons.shopping_cart_outlined,
                      color: Color(0xFF1B1B18),
                      size: 30,
                    ),
                  ),
                  if (cart.totalQuantity > 0)
                    Positioned(
                      right: 4,
                      top: 4,
                      child: Container(
                        padding: const EdgeInsets.all(4),
                        decoration: const BoxDecoration(
                          color: Color(0xFFD97706),
                          shape: BoxShape.circle,
                        ),
                        constraints: const BoxConstraints(
                          minWidth: 18,
                          minHeight: 18,
                        ),
                        child: Text(
                          '${cart.totalQuantity}',
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 10,
                            fontWeight: FontWeight.bold,
                          ),
                          textAlign: TextAlign.center,
                        ),
                      ),
                    ),
                ],
              );
            },
          ),
          const SizedBox(width: 16),
        ],
        bottom: PreferredSize(
          preferredSize: const Size.fromHeight(1),
          child: Container(color: const Color(0xFFE5E7EB), height: 1),
        ),
      ),
      body: Consumer<CartProvider>(
        builder: (context, cart, child) {
          if (cart.items.isEmpty) {
            return Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.shopping_cart_outlined, size: 80, color: Colors.grey.shade400),
                  const SizedBox(height: 16),
                  const Text(
                    "Your cart is empty",
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.grey),
                  ),
                  const SizedBox(height: 20),
                  ElevatedButton(
                    onPressed: () => Navigator.pop(context),
                    child: const Text("Go Shopping"),
                  ),
                ],
              ),
            );
          }

          return SingleChildScrollView(
            child: Column(
              children: [
                const SizedBox(height: 32),
                // 🛒 Your Shopping Cart Title
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: FittedBox(
                    fit: BoxFit.scaleDown,
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Text(
                          "🛒",
                          style: TextStyle(fontSize: 32),
                        ),
                        const SizedBox(width: 12),
                        const Text(
                          "Your Shopping Cart",
                          style: TextStyle(
                            fontSize: 28,
                            fontWeight: FontWeight.bold,
                            color: Color(0xFF92400E), // amber-800
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
                const SizedBox(height: 32),

                // Cart Items Container
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: Container(
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(16),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.08),
                          blurRadius: 15,
                          offset: const Offset(0, 5),
                        ),
                      ],
                    ),
                    child: Column(
                      children: [
                        // List of items
                        ListView.separated(
                          shrinkWrap: true,
                          physics: const NeverScrollableScrollPhysics(),
                          itemCount: cart.items.length,
                          separatorBuilder: (context, index) => const Divider(height: 1, color: Color(0xFFF3F4F6)),
                          itemBuilder: (context, index) {
                            final cartItem = cart.items[index];
                            final product = cartItem.product;

                            return Padding(
                              padding: const EdgeInsets.all(20),
                              child: Stack(
                                children: [
                                  Row(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      // Image
                                      ClipRRect(
                                        borderRadius: BorderRadius.circular(10),
                                        child: Image.network(
                                          ApiService.getImageUrl(product.image),
                                          width: 90,
                                          height: 90,
                                          fit: BoxFit.cover,
                                          errorBuilder: (_, __, ___) => Container(
                                            width: 90, height: 90, color: Colors.grey[100],
                                            child: const Icon(Icons.fitness_center, color: Colors.grey),
                                          ),
                                        ),
                                      ),
                                      const SizedBox(width: 20),
                                      
                                      // Details
                                      Expanded(
                                        child: Column(
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Text(
                                              product.title,
                                              style: const TextStyle(
                                                fontSize: 20,
                                                fontWeight: FontWeight.bold,
                                                color: Color(0xFF1B1B18),
                                              ),
                                            ),
                                            Text(
                                              "LKR ${product.price} / unit",
                                              style: const TextStyle(
                                                fontSize: 15,
                                                color: Color(0xFF6B7280),
                                              ),
                                            ),
                                            const SizedBox(height: 20),
                                            
                                            // Controls + Subtotal
                                            Wrap(
                                              alignment: WrapAlignment.spaceBetween,
                                              crossAxisAlignment: WrapCrossAlignment.center,
                                              spacing: 8,
                                              runSpacing: 8,
                                              children: [
                                                // Quantity Selector
                                                Container(
                                                  height: 38,
                                                  decoration: BoxDecoration(
                                                    color: const Color(0xFFF9FAFB),
                                                    borderRadius: BorderRadius.circular(8),
                                                    border: Border.all(color: const Color(0xFFE5E7EB)),
                                                  ),
                                                  child: Row(
                                                    mainAxisSize: MainAxisSize.min,
                                                    children: [
                                                      IconButton(
                                                        constraints: const BoxConstraints(minWidth: 36, minHeight: 36),
                                                        padding: EdgeInsets.zero,
                                                        icon: const Icon(Icons.remove, size: 16, color: Color(0xFF6B7280)),
                                                        onPressed: () => cart.updateQuantity(product, cartItem.quantity - 1),
                                                      ),
                                                      Container(
                                                        width: 30,
                                                        alignment: Alignment.center,
                                                        child: Text(
                                                          "${cartItem.quantity}",
                                                          style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold),
                                                        ),
                                                      ),
                                                      IconButton(
                                                        constraints: const BoxConstraints(minWidth: 36, minHeight: 36),
                                                        padding: EdgeInsets.zero,
                                                        icon: const Icon(Icons.add, size: 16, color: Color(0xFF6B7280)),
                                                        onPressed: () => cart.updateQuantity(product, cartItem.quantity + 1),
                                                      ),
                                                    ],
                                                  ),
                                                ),
                                                
                                                // Item Total
                                                Text(
                                                  _formatPrice(cartItem.totalPrice),
                                                  style: const TextStyle(
                                                    fontSize: 16,
                                                    fontWeight: FontWeight.bold,
                                                    color: Color(0xFFD97706), // amber-600
                                                  ),
                                                ),
                                              ],
                                            ),
                                          ],
                                        ),
                                      ),
                                    ],
                                  ),
                                  
                                  // Remove Button (X)
                                  Positioned(
                                    top: 0,
                                    right: 0,
                                    child: GestureDetector(
                                      onTap: () => cart.removeFromCart(product),
                                      child: const Icon(Icons.close, size: 24, color: Color(0xFF9CA3AF)),
                                    ),
                                  ),
                                ],
                              ),
                            );
                          },
                        ),

                        // Summary section box inside the card
                        Container(
                          padding: const EdgeInsets.all(24),
                          decoration: const BoxDecoration(
                            border: Border(top: BorderSide(color: Color(0xFFF3F4F6), width: 1.5)),
                          ),
                          child: Column(
                            children: [
                              Row(
                                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                children: [
                                  const Expanded(
                                    child: Text(
                                      "Total Amount",
                                      style: TextStyle(fontSize: 18, color: Color(0xFF4B5563), fontWeight: FontWeight.w500),
                                    ),
                                  ),
                                  const SizedBox(width: 8),
                                  Flexible(
                                    child: FittedBox(
                                      fit: BoxFit.scaleDown,
                                      alignment: Alignment.centerRight,
                                      child: Text(
                                        _formatPrice(cart.totalAmount),
                                        style: const TextStyle(
                                          fontSize: 24,
                                          fontWeight: FontWeight.bold,
                                          color: Color(0xFF1B1B18),
                                        ),
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                              const SizedBox(height: 32),
                              
                              // Clear Cart Button
                              SizedBox(
                                width: double.infinity,
                                child: OutlinedButton(
                                  onPressed: () => cart.clearCart(),
                                  style: OutlinedButton.styleFrom(
                                    padding: const EdgeInsets.symmetric(vertical: 16),
                                    side: const BorderSide(color: Color(0xFFE5E7EB)),
                                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                                  ),
                                  child: const Text(
                                    "Clear Cart", 
                                    style: TextStyle(color: Color(0xFF374151), fontSize: 16, fontWeight: FontWeight.w500)
                                  ),
                                ),
                              ),
                              const SizedBox(height: 16),
                              
                              // Proceed Button
                              SizedBox(
                                width: double.infinity,
                                child: ElevatedButton(
                                  onPressed: () {
                                    Navigator.push(
                                      context,
                                      MaterialPageRoute(builder: (context) => const CheckoutPage()),
                                    );
                                  },
                                  style: ElevatedButton.styleFrom(
                                    backgroundColor: const Color(0xFFD97706), // amber-600
                                    padding: const EdgeInsets.symmetric(vertical: 16),
                                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                                    elevation: 2,
                                  ),
                                  child: const Row(
                                    mainAxisAlignment: MainAxisAlignment.center,
                                    children: [
                                      Text(
                                        "Proceed to Checkout",
                                        style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.white),
                                      ),
                                      SizedBox(width: 8),
                                      Icon(Icons.arrow_forward, color: Colors.white),
                                    ],
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ),

                const SizedBox(height: 60),
                const Footer(),
              ],
            ),
          );
        },
      ),
    );
  }
}
