import 'package:flutter/material.dart';
import 'package:grindhouse_app/components/footer.dart';
import 'package:grindhouse_app/services/api_service.dart';

class ContactUsPage extends StatefulWidget {
  const ContactUsPage({super.key});

  @override
  State<ContactUsPage> createState() => _ContactUsPageState();
}

class _ContactUsPageState extends State<ContactUsPage> {
  final _formKey = GlobalKey<FormState>();
  
  // Controllers
  final TextEditingController _firstNameController = TextEditingController();
  final TextEditingController _lastNameController = TextEditingController();
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _messageController = TextEditingController();

  bool _isSubmitting = false;
  String? _errorText;

  Future<void> _sendMessage() async {
    if (!_formKey.currentState!.validate()) {
      return;
    }

    setState(() {
      _isSubmitting = true;
      _errorText = null;
    });

    final payload = {
      'first_name': _firstNameController.text.trim(),
      'last_name': _lastNameController.text.trim().isEmpty
          ? null
          : _lastNameController.text.trim(),
      'email': _emailController.text.trim(),
      'message': _messageController.text.trim(),
    };

    final result = await ApiService.sendContactMessage(payload);

    if (!mounted) return;

    if (result != null && result['success'] == true) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("✅ Your message has been sent successfully."),
          backgroundColor: Colors.green,
          behavior: SnackBarBehavior.floating,
        ),
      );

      _firstNameController.clear();
      _lastNameController.clear();
      _emailController.clear();
      _messageController.clear();
    } else {
      setState(() {
        _errorText = "Failed to send message. Please try again.";
      });
    }

    setState(() {
      _isSubmitting = false;
    });
  }

  @override
  void dispose() {
    _firstNameController.dispose();
    _lastNameController.dispose();
    _emailController.dispose();
    _messageController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    // Theme references match the screenshot colors (Amber/Brown)
    
    return SingleChildScrollView(
      child: Column(
        children: [
          Container(
            width: double.infinity,
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 32),
            color: Colors.white,
            child: Column(
              children: [
                // Page Title
                const Text(
                  "Contact Us",
                  style: TextStyle(
                    fontSize: 28,
                    fontWeight: FontWeight.bold,
                    color: Color(0xFF92400E), // text-amber-900 approx
                  ),
                ),
                
                const SizedBox(height: 32),
                
                // Form Card
                Container(
                  constraints: const BoxConstraints(maxWidth: 600),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(16),
                    border: Border.all(color: const Color(0xFFFDE68A), width: 1.5), // border-amber-200
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withValues(alpha: 0.05),
                        blurRadius: 10,
                        offset: const Offset(0, 4),
                      ),
                    ],
                  ),
                  padding: const EdgeInsets.all(24),
                  child: Form(
                    key: _formKey,
                    child: Column(
                      children: [
                        // Get in Touch Header
                        const Text(
                          "Get in Touch",
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: Color(0xFF1F2937), // gray-800
                          ),
                        ),
                        const SizedBox(height: 12),
                        const Text(
                          "Have questions about our equipment or services? Our team at GRINDHOUSE.LK is ready to help. Fill out the form below.",
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 14,
                            color: Color(0xFF4B5563), // gray-600
                            height: 1.5,
                          ),
                        ),
                        
                        const SizedBox(height: 32),

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
                          const SizedBox(height: 16),
                        ],
                        
                        // Input Fields
                        _buildTextField(
                          controller: _firstNameController,
                          label: "First Name *",
                          validator: (value) => 
                            value == null || value.isEmpty ? 'First Name is required' : null,
                        ),
                        const SizedBox(height: 16),
                        _buildTextField(
                          controller: _lastNameController,
                          label: "Last Name",
                        ),
                        const SizedBox(height: 16),
                        _buildTextField(
                          controller: _emailController,
                          label: "Email *",
                          keyboardType: TextInputType.emailAddress,
                           validator: (value) {
                            if (value == null || value.isEmpty) return 'Email is required';
                            if (!value.contains('@')) return 'Please enter a valid email';
                            return null;
                          },
                        ),
                        const SizedBox(height: 16),
                        _buildTextField(
                          controller: _messageController,
                          label: "Write your message here...",
                          maxLines: 5,
                           validator: (value) => 
                            value == null || value.isEmpty ? 'Message is required' : null,
                        ),
                        
                        const SizedBox(height: 32),
                        
                        // Submit Button
                        SizedBox(
                          width: double.infinity,
                          height: 50,
                          child: ElevatedButton(
                            onPressed: _isSubmitting ? null : _sendMessage,
                            style: ElevatedButton.styleFrom(
                              backgroundColor: const Color(0xFFD97706), // amber-600
                              foregroundColor: Colors.white,
                              elevation: 0,
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(8),
                              ),
                              textStyle: const TextStyle(
                                fontSize: 16,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                            child: _isSubmitting
                                ? const SizedBox(
                                    height: 20,
                                    width: 20,
                                    child: CircularProgressIndicator(
                                      strokeWidth: 2,
                                      color: Colors.white,
                                    ),
                                  )
                                : const Text("Send Message"),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ],
            ),
          ),
          
          // Footer
          const Footer(),
        ],
      ),
    );
  }

  Widget _buildTextField({
    required TextEditingController controller,
    required String label,
    int maxLines = 1,
    TextInputType? keyboardType,
    String? Function(String?)? validator,
  }) {
    return TextFormField(
      controller: controller,
      maxLines: maxLines,
      keyboardType: keyboardType,
      validator: validator,
      style: const TextStyle(fontSize: 14, color: Colors.black87),
      decoration: InputDecoration(
        hintText: label,
        hintStyle: TextStyle(color: Colors.grey.shade500, fontSize: 14),
        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
        filled: true,
        fillColor: Colors.white,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: BorderSide(color: Colors.grey.shade300),
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: BorderSide(color: Colors.grey.shade300),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: Color(0xFFD97706), width: 1.5), // Focus amber
        ),
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: BorderSide(color: Colors.red.shade400),
        ),
      ),
    );
  }
}
