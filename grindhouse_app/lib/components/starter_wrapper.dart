import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:grindhouse_app/screens/homescreen.dart';
import 'package:grindhouse_app/screens/products_page.dart';
import 'package:grindhouse_app/screens/contact_us.dart';
import 'package:grindhouse_app/screens/cart_screen.dart';
import 'package:grindhouse_app/screens/cart_provider.dart';
import 'package:grindhouse_app/screens/login_page.dart';
import 'package:grindhouse_app/screens/profile_screen.dart';
import 'package:grindhouse_app/services/api_service.dart';

class Wrapper extends StatefulWidget {
  const Wrapper({super.key});

  @override
  State<Wrapper> createState() => _WrapperState();
}

class _WrapperState extends State<Wrapper> {
  int _selectedIndex = 0;
  bool _isLoggedIn = false;
  late List<Widget> _screens;

  // Make this method public
  void changeTab(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  void initState() {
    super.initState();
    _screens = [
      HomeScreen(onTabChange: changeTab),
      const ProductsPage(),
      const ContactUsPage(),
      ProfileScreen(onLogout: () {
        setState(() {
          _selectedIndex = 0; // Go back to Home
        });
      }),
    ];
  }

  void _onItemTapped(int index) async {
    if (index == 3) {
      if (!ApiService.isLoggedIn) {
        final result = await Navigator.push(
          context,
          MaterialPageRoute(builder: (context) => const LoginPage()),
        );
        if (result == true && mounted) {
          setState(() {
            _selectedIndex = 3;
          });
        }
        return;
      }
    }
    setState(() {
      _selectedIndex = index;
    });
  }

  PreferredSizeWidget _buildTopAppBar(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    final user = ApiService.user;
    final isLoggedIn = ApiService.isLoggedIn;

    return AppBar(
      backgroundColor: isDark ? const Color(0xFF1A1A1A) : const Color(0xFFFFFBEB),
      elevation: 0, 
      toolbarHeight: 80,
      titleSpacing: 0,
      centerTitle: false,
      shape: Border(bottom: BorderSide(color: isDark ? Colors.grey.shade900 : const Color(0xFFE5E7EB), width: 1)),
      title: Padding(
        padding: const EdgeInsets.only(left: 16),
        child: GestureDetector(
          onTap: () => changeTab(0),
          child: Image.asset(
            'assets/images/logo.png',
            height: 40,
            fit: BoxFit.contain,
          ),
        ),
      ),
      actions: [
        // User Profile / Login Link - Only shows when logged in
        if (isLoggedIn)
          PopupMenuButton<String>(
            onSelected: (value) async {
              if (value == 'profile') {
                setState(() {
                  _selectedIndex = 3;
                });
              } else if (value == 'logout') {
                await ApiService.logout();
                setState(() {
                  _selectedIndex = 0;
                });
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
                    user?['name'] ?? "User",
                    style: TextStyle(
                      color: isDark ? Colors.white : const Color(0xFF1B1B18),
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  Icon(
                    Icons.keyboard_arrow_down,
                    color: isDark ? Colors.white70 : Colors.grey,
                    size: 20,
                  ),
                ],
              ),
            ),
          ),
        const SizedBox(width: 8),
        // Cart Icon
        Consumer<CartProvider>(
          builder: (context, cart, child) {
            return Center(
              child: Padding(
                padding: const EdgeInsets.only(right: 16),
                child: Stack(
                  alignment: Alignment.center,
                  children: [
                    IconButton(
                      onPressed: () {
                        Navigator.of(context).push(
                          MaterialPageRoute(
                            builder: (context) => const CartScreen(),
                          ),
                        );
                      },
                      icon: Icon(
                        Icons.shopping_cart_outlined,
                        color: isDark ? Colors.white : const Color(0xFF1B1B18),
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
                ),
              ),
            );
          },
        ),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: _buildTopAppBar(context),
      body: _screens[_selectedIndex],
      bottomNavigationBar: Container(
        decoration: const BoxDecoration(
           border: Border(top: BorderSide(color: Color(0xFFE5E7EB))), // border-gray-200
        ),
        child: BottomNavigationBar(
          currentIndex: _selectedIndex,
          backgroundColor: Colors.white,
          type: BottomNavigationBarType.fixed,
          selectedItemColor: const Color(0xFFD97706), // amber-600
          unselectedItemColor: const Color(0xFF706F6C), // footer text color
          selectedFontSize: 12,
          unselectedFontSize: 12,
          onTap: _onItemTapped,
          items: [
            const BottomNavigationBarItem(
              icon: Icon(Icons.home_outlined),
              activeIcon: Icon(Icons.home),
              label: "Home",
            ),
            const BottomNavigationBarItem(
              icon: Icon(Icons.shopping_bag_outlined),
              activeIcon: Icon(Icons.shopping_bag),
              label: "Products",
            ),
            const BottomNavigationBarItem(
              icon: Icon(Icons.email_outlined),
              activeIcon: Icon(Icons.email),
              label: "Contact",
            ),
            BottomNavigationBarItem(
              icon: const Icon(Icons.person_outline),
              activeIcon: const Icon(Icons.person),
              label: ApiService.isLoggedIn 
                  ? (ApiService.user?['name'] ?? "Account") 
                  : "Account",
            ),
          ],
        ),
      ),
    );
  }
}