import 'package:flutter/material.dart';

class Footer extends StatelessWidget {
  const Footer({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      color: const Color(0xFFFFFBEB), // match amber-50 background
      padding: const EdgeInsets.symmetric(vertical: 40, horizontal: 16),
      child: Column(
        children: [
          // Brand Logo Section - Centered
          const Text(
            "GRINDHOUSE.LK",
            style: TextStyle(
              fontWeight: FontWeight.w600,
              fontSize: 18,
              letterSpacing: 1.2,
              color: Color(0xFF1B1B18),
            ),
          ),
          const SizedBox(height: 16),
          Image.asset(
            'assets/images/logo.png',
            width: 80,
            height: 80,
            fit: BoxFit.contain,
          ),

          const SizedBox(height: 48),

          // Two-Column Section for ABOUT and CONTACT
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // ABOUT Column
              Expanded(
                child: Column(
                  children: [
                    _buildFooterHeader("ABOUT"),
                    const Text(
                      "GRINDHOUSE (PVT) LTD\n18, Maharagama,\nColombo",
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 14,
                        height: 1.6,
                        color: Color(0xFF4B5563),
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),
              // CONTACT Column
              Expanded(
                child: Column(
                  children: [
                    _buildFooterHeader("CONTACT"),
                    const Text(
                      "+94 112 123 456",
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF1F2937),
                      ),
                    ),
                    const SizedBox(height: 8),
                    const Text(
                      "info@grindhouse.lk",
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 14,
                        color: Color(0xFF4B5563),
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),

          const SizedBox(height: 48),

          // LINKS Section - Centered
          _buildFooterHeader("LINKS"),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              _buildFooterLink("Home"),
              const SizedBox(width: 16),
              _buildFooterLink("Products"),
              const SizedBox(width: 16),
              _buildFooterLink("About"),
              const SizedBox(width: 16),
              _buildFooterLink("Contact"),
            ],
          ),

          const SizedBox(height: 40),

          // Divider line
          const Divider(color: Color(0xFFFFE082), thickness: 1), // amber-200 line

          const SizedBox(height: 24),

          // Copyright
          const Text(
            "© 2026 GRINDHOUSE.LK. All rights reserved.",
            textAlign: TextAlign.center,
            style: TextStyle(
              fontSize: 12,
              color: Color(0xFF6B7280),
              fontWeight: FontWeight.w400,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildFooterHeader(String title) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: Text(
        title,
        style: const TextStyle(
          fontWeight: FontWeight.w600,
          fontSize: 16,
          color: Color(0xFF92400E), // Match the amber-800 header color in screenshot
          letterSpacing: 1.1,
        ),
      ),
    );
  }

  Widget _buildFooterLink(String text) {
    return Text(
      text,
      style: const TextStyle(
        fontSize: 14,
        color: Color(0xFF1F2937),
        fontWeight: FontWeight.w500,
      ),
    );
  }
}
