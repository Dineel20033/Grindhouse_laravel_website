import 'package:flutter/material.dart';
import 'package:grindhouse_app/services/api_service.dart';

class ProfileScreen extends StatefulWidget {
  final VoidCallback? onLogout;

  const ProfileScreen({super.key, this.onLogout});

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  final _nameController = TextEditingController();
  final _emailController = TextEditingController();
  
  final _currentPasswordController = TextEditingController();
  final _newPasswordController = TextEditingController();
  final _confirmPasswordController = TextEditingController();

  bool _isLoadingProfile = false;
  bool _isLoadingPassword = false;
  bool _isLoadingDelete = false;

  List<dynamic> _orders = [];
  bool _isLoadingOrders = false;
  String? _ordersError;

  @override
  void initState() {
    super.initState();
    final user = ApiService.user;
    _nameController.text = user?['name'] ?? "";
    _emailController.text = user?['email'] ?? "";
    _loadOrders();
  }

  @override
  void dispose() {
    _nameController.dispose();
    _emailController.dispose();
    _currentPasswordController.dispose();
    _newPasswordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
  }

  Future<void> _updateProfile() async {
    setState(() => _isLoadingProfile = true);
    final result = await ApiService.updateProfile(
      _nameController.text,
      _emailController.text,
    );
    setState(() => _isLoadingProfile = false);

    if (result != null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text("Profile updated successfully"), backgroundColor: Colors.green),
      );
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text("Failed to update profile"), backgroundColor: Colors.red),
      );
    }
  }

  Future<void> _loadOrders() async {
    setState(() {
      _isLoadingOrders = true;
      _ordersError = null;
    });

    final orders = await ApiService.getOrderHistory();

    if (!mounted) return;

    setState(() {
      _isLoadingOrders = false;
      if (orders == null) {
        _ordersError = "Failed to load order history.";
        _orders = [];
      } else {
        _orders = orders;
      }
    });
  }

  Future<void> _updatePassword() async {
    if (_newPasswordController.text != _confirmPasswordController.text) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text("Passwords do not match"), backgroundColor: Colors.red),
      );
      return;
    }

    setState(() => _isLoadingPassword = true);
    final result = await ApiService.updatePassword(
      _currentPasswordController.text,
      _newPasswordController.text,
      _confirmPasswordController.text,
    );
    setState(() => _isLoadingPassword = false);

    if (result != null) {
      _currentPasswordController.clear();
      _newPasswordController.clear();
      _confirmPasswordController.clear();
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text("Password updated successfully"), backgroundColor: Colors.green),
      );
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text("Failed to update password. Check your current password."), backgroundColor: Colors.red),
      );
    }
  }

  Future<void> _deleteAccount() async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text("Delete Account"),
        content: const Text("Are you sure you want to delete your account? This action cannot be undone."),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context, false), child: const Text("Cancel")),
          TextButton(
            onPressed: () => Navigator.pop(context, true),
            child: const Text("Delete", style: TextStyle(color: Colors.red)),
          ),
        ],
      ),
    );

    if (confirm == true) {
      setState(() => _isLoadingDelete = true);
      final success = await ApiService.deleteAccount();
      setState(() => _isLoadingDelete = false);

      if (success && widget.onLogout != null) {
        widget.onLogout!();
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    const amberColor = Color(0xFFFFBF00);

    return Scaffold(
      backgroundColor: isDark ? const Color(0xFF111111) : const Color(0xFFF9FAFB),
      body: SingleChildScrollView(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 24),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildSectionHeader(
              "Profile Information",
              "Update your account's profile information and email address.",
              isDark,
            ),
            const SizedBox(height: 16),
            _buildSectionCard(
              isDark,
              children: [
                _buildTextField(
                  label: "Name",
                  controller: _nameController,
                  isDark: isDark,
                  amberColor: amberColor,
                ),
                const SizedBox(height: 16),
                _buildTextField(
                  label: "Email",
                  controller: _emailController,
                  isDark: isDark,
                  amberColor: amberColor,
                ),
                const SizedBox(height: 24),
                _buildSaveButton(
                  onPressed: _updateProfile,
                  isLoading: _isLoadingProfile,
                  amberColor: amberColor,
                ),
              ],
            ),
            
            const SizedBox(height: 48), // Large gap between sections
            _buildSectionHeader(
              "Update Password",
              "Ensure your account is using a long, random password to stay secure.",
              isDark,
            ),
            const SizedBox(height: 16),
            _buildSectionCard(
              isDark,
              children: [
                _buildTextField(
                  label: "Current Password",
                  controller: _currentPasswordController,
                  isDark: isDark,
                  amberColor: amberColor,
                  isPassword: true,
                ),
                const SizedBox(height: 16),
                _buildTextField(
                  label: "New Password",
                  controller: _newPasswordController,
                  isDark: isDark,
                  amberColor: amberColor,
                  isPassword: true,
                ),
                const SizedBox(height: 16),
                _buildTextField(
                  label: "Confirm Password",
                  controller: _confirmPasswordController,
                  isDark: isDark,
                  amberColor: amberColor,
                  isPassword: true,
                ),
                const SizedBox(height: 24),
                _buildSaveButton(
                  onPressed: _updatePassword,
                  isLoading: _isLoadingPassword,
                  amberColor: amberColor,
                ),
              ],
            ),

            const SizedBox(height: 48),
            _buildSectionHeader(
              "Order History",
              "View your past orders and items purchased.",
              isDark,
            ),
            const SizedBox(height: 16),
            _buildSectionCard(
              isDark,
              children: [
                _buildOrderHistoryContent(isDark),
              ],
            ),

            const SizedBox(height: 48),
            _buildSectionHeader(
              "Delete Account",
              "Once your account is deleted, all of its resources and data will be permanently deleted.",
              isDark,
            ),
            const SizedBox(height: 16),
            _buildSectionCard(
              isDark,
              children: [
                const Text(
                  "Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.",
                  style: TextStyle(fontSize: 14, color: Color(0xFF6B7280), height: 1.5),
                ),
                const SizedBox(height: 20),
                ElevatedButton(
                  onPressed: _isLoadingDelete ? null : _deleteAccount,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFFEF4444),
                    foregroundColor: Colors.white,
                    padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                    elevation: 0,
                  ),
                  child: _isLoadingDelete
                      ? const SizedBox(height: 20, width: 20, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2))
                      : const Text("Delete Account", style: TextStyle(fontWeight: FontWeight.bold)),
                ),
              ],
            ),
            const SizedBox(height: 60), // Extra space for bottom nav
            
            // Re-adding logout as a standard profile option at the bottom
             SizedBox(
                width: double.infinity,
                child: TextButton.icon(
                  onPressed: () async {
                    await ApiService.logout();
                    if (widget.onLogout != null) widget.onLogout!();
                  },
                  icon: const Icon(Icons.logout, color: Colors.grey),
                  label: const Text("Logout", style: TextStyle(color: Colors.grey)),
                ),
              ),
            const SizedBox(height: 20),
          ],
        ),
      ),
    );
  }

  Widget _buildSectionHeader(String title, String description, bool isDark) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          title,
          style: TextStyle(
            fontSize: 22, // Increased size
            fontWeight: FontWeight.w700, // Bolder
            color: isDark ? Colors.white : const Color(0xFF111827),
          ),
        ),
        const SizedBox(height: 8), // More space
        Text(
          description,
          style: TextStyle(
            fontSize: 15, // Slightly larger
            color: isDark ? Colors.grey[400] : const Color(0xFF6B7280), // Tailwind gray-500
            height: 1.5, // Better line height
          ),
        ),
      ],
    );
  }

  Widget _buildSectionCard(bool isDark, {required List<Widget> children}) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20), // Adjusted padding
      decoration: BoxDecoration(
        color: isDark ? const Color(0xFF1A1A1A) : Colors.white,
        borderRadius: BorderRadius.circular(16), // More rounded like modern cards
        boxShadow: isDark ? [] : [
          BoxShadow(
            color: Colors.black.withOpacity(0.04), // Very subtle shadow
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: children,
      ),
    );
  }

  Widget _buildOrderHistoryContent(bool isDark) {
    if (_isLoadingOrders) {
      return const Center(
        child: Padding(
          padding: EdgeInsets.all(12),
          child: CircularProgressIndicator(),
        ),
      );
    }

    if (_ordersError != null) {
      return Text(
        _ordersError!,
        style: TextStyle(color: isDark ? Colors.red[300] : Colors.red[600]),
      );
    }

    if (_orders.isEmpty) {
      return Text(
        "No orders yet.",
        style: TextStyle(color: isDark ? Colors.grey[400] : const Color(0xFF6B7280)),
      );
    }

    return Column(
      children: _orders.map((order) {
        final orderMap = Map<String, dynamic>.from(order as Map);
        return _buildOrderCard(orderMap, isDark);
      }).toList(),
    );
  }

  Widget _buildOrderCard(Map<String, dynamic> order, bool isDark) {
    final items = (order['items'] as List?) ?? [];
    final dateText = _formatDate(order['created_at']);
    final totalText = order['total']?.toString() ?? "0";

    return Container(
      width: double.infinity,
      margin: const EdgeInsets.only(bottom: 12),
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: isDark ? const Color(0xFF242424) : const Color(0xFFF9FAFB),
        borderRadius: BorderRadius.circular(10),
        border: Border.all(color: isDark ? Colors.white10 : const Color(0xFFE5E7EB)),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            "Order #${order['id']} • $dateText",
            style: TextStyle(
              fontWeight: FontWeight.w600,
              color: isDark ? Colors.white : const Color(0xFF111827),
            ),
          ),
          const SizedBox(height: 6),
          Text(
            "Total: $totalText",
            style: TextStyle(color: isDark ? Colors.grey[300] : const Color(0xFF374151)),
          ),
          const SizedBox(height: 10),
          ...items.map((item) {
            final itemMap = Map<String, dynamic>.from(item as Map);
            return Padding(
              padding: const EdgeInsets.only(bottom: 6),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Expanded(
                    child: Text(
                      itemMap['product_name'] ?? '',
                      style: TextStyle(color: isDark ? Colors.grey[200] : const Color(0xFF111827)),
                    ),
                  ),
                  Text(
                    "x${itemMap['quantity']} • ${itemMap['price']}",
                    style: TextStyle(color: isDark ? Colors.grey[400] : const Color(0xFF6B7280)),
                  ),
                ],
              ),
            );
          }).toList(),
        ],
      ),
    );
  }

  String _formatDate(String? iso) {
    if (iso == null) return '';
    final dt = DateTime.tryParse(iso);
    if (dt == null) return '';
    final m = dt.month.toString().padLeft(2, '0');
    final d = dt.day.toString().padLeft(2, '0');
    return "${dt.year}-$m-$d";
  }

  Widget _buildTextField({
    required String label,
    required TextEditingController controller,
    required bool isDark,
    required Color amberColor,
    bool isPassword = false,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: TextStyle(
            fontSize: 15,
            fontWeight: FontWeight.w500,
            color: isDark ? Colors.grey[300] : const Color(0xFF374151),
          ),
        ),
        const SizedBox(height: 6), // Tight spacing like screenshot
        TextField(
          controller: controller,
          obscureText: isPassword,
          style: TextStyle(color: isDark ? Colors.white : Colors.black, fontSize: 16),
          decoration: InputDecoration(
            filled: true,
            fillColor: isDark ? const Color(0xFF2D2D2D) : Colors.white,
            contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
            enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(10),
              borderSide: BorderSide(color: isDark ? Colors.white12 : const Color(0xFFE5E7EB)),
            ),
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(10),
              borderSide: BorderSide(color: amberColor, width: 2),
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildSaveButton({
    required VoidCallback onPressed,
    required bool isLoading,
    required Color amberColor,
  }) {
    return Align(
      alignment: Alignment.centerRight,
      child: ElevatedButton(
        onPressed: isLoading ? null : onPressed,
        style: ElevatedButton.styleFrom(
          backgroundColor: const Color(0xFF0F172A), // Tailwind slate-900 (Darker/Vibrant Black)
          foregroundColor: Colors.white,
          padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 14),
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
          elevation: 0,
        ),
        child: isLoading
            ? const SizedBox(height: 18, width: 18, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2))
            : const Text("Save", style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15)),
      ),
    );
  }
}
