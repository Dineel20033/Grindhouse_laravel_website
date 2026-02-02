import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:video_player/video_player.dart';
import 'package:grindhouse_app/screens/product_model.dart';
import 'package:grindhouse_app/screens/category_model.dart';
import 'package:grindhouse_app/screens/products_details.dart';
import 'package:grindhouse_app/screens/cart_provider.dart';
import 'package:grindhouse_app/components/footer.dart';
import 'package:grindhouse_app/services/api_service.dart';

class HomeScreen extends StatefulWidget {
  final Function(int) onTabChange;
  
  const HomeScreen({super.key, required this.onTabChange});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  // Lists to be populated from database
  List<Product> featuredProducts = [];
  List<Category> categories = [];
  bool isLoading = true;

  late VideoPlayerController _videoController;
  bool _isVideoInitialized = false;

  @override
  void initState() {
    super.initState();
    _fetchData();
    _initializeVideo();
  }

  void _initializeVideo() {
    _videoController = VideoPlayerController.networkUrl(
      Uri.parse(ApiService.getAssetUrl('assets/videos/gym_video.mp4')),
    );
    
    _videoController.initialize().then((_) {
        if (mounted) {
          setState(() {
            _isVideoInitialized = true;
            _videoController.setLooping(true);
            _videoController.setVolume(0);
            _videoController.play();
          });
        }
      }).catchError((error) {
        debugPrint("Video error: $error");
        // Fallback for demo
        _videoController = VideoPlayerController.networkUrl(
          Uri.parse('https://flutter.github.io/assets-for-api-docs/assets/videos/butterfly.mp4'),
        );
        
        _videoController.initialize().then((_) {
            if (mounted) {
              setState(() {
                _isVideoInitialized = true;
                _videoController.setLooping(true);
                _videoController.setVolume(0);
                _videoController.play();
              });
            }
          });
      });
  }

  @override
  void dispose() {
    _videoController.dispose();
    super.dispose();
  }

  Future<void> _fetchData() async {
    setState(() => isLoading = true);
    try {
      // Fetch dynamic categories from API
      final categoryData = await ApiService.getCategories();
      if (categoryData != null && categoryData is List) {
        setState(() {
          categories = categoryData.map((c) => Category.fromJson(c)).toList();
        });
      }

      // Fetch featured products from API
      final productData = await ApiService.getProducts();
      if (productData != null) {
        setState(() {
          // Take first 4 as featured
          featuredProducts = productData.take(4).map((p) => Product.fromJson(p)).toList();
        });
      }
    } catch (e) {
      debugPrint("Error fetching home screen data: $e");
    } finally {
      if (mounted) {
        setState(() => isLoading = false);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    final mediaQuery = MediaQuery.of(context);
    final isLandscape = mediaQuery.orientation == Orientation.landscape;
    
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Hero Banner
           Stack(
            children: [
              Container(
                width: double.infinity,
                height: isLandscape ? 220 : 350, // Slightly reduced height
                child: _isVideoInitialized
                    ? VideoPlayer(_videoController)
                    : Image.asset(
                        "assets/images/hero_banner.png",
                        fit: BoxFit.cover,
                      ),
              ),
              // Dark overlay for better text contrast
              Container(
                width: double.infinity,
                height: isLandscape ? 220 : 350,
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    end: Alignment.bottomCenter,
                    colors: [
                      Colors.black.withOpacity(0.5),
                      Colors.black.withOpacity(0.3),
                      Colors.black.withOpacity(0.5),
                    ],
                  ),
                ),
              ),
              Container(
                 width: double.infinity,
                height: isLandscape ? 220 : 350,
                padding: const EdgeInsets.symmetric(horizontal: 24),
                alignment: Alignment.center,
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const Text(
                      "GRINDHOUSE.LK",
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 36, // Reduced from 48
                        fontWeight: FontWeight.bold,
                        letterSpacing: 1.2,
                        height: 1.1,
                      ),
                    ),
                    const SizedBox(height: 12),
                    const Text(
                      "Unleash your strength. Equip your journey.",
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 16, // Reduced from 18
                        fontWeight: FontWeight.w400, 
                        letterSpacing: 0.5,
                      ),
                    ),
                    const SizedBox(height: 30),
                    ElevatedButton(
                      onPressed: () {
                         widget.onTabChange(1);
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: const Color(0xFFD97706), // amber-600
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 14), // Reduced padding
                        elevation: 6,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(8),
                        ),
                      ),
                      child: const Text(
                        "Shop Now",
                        style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold), // Reduced from 18
                      ),
                    )
                  ],
                ),
              ),
            ],
          ),

          // Distinct Categories Section
          Container(
            padding: EdgeInsets.symmetric(vertical: isLandscape ? 24 : 40, horizontal: 16),
            color: isDark ? null : Colors.white,
            child: Column(
              children: [
                const Text(
                  "Browse Categories",
                  style: TextStyle(
                    fontSize: 28, 
                    fontWeight: FontWeight.bold,
                    color: Color(0xFF92400E), // amber-800
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 32),
                
                if (isLoading)
                  const Center(child: CircularProgressIndicator())
                else
                  GridView.builder(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisCount: isLandscape ? 4 : 2,
                      crossAxisSpacing: 16,
                      mainAxisSpacing: 16,
                      childAspectRatio: 0.8, 
                    ),
                    itemCount: categories.length,
                    itemBuilder: (context, index) {
                      return _buildCategoryCard(categories[index]);
                    },
                  ),
              ],
            ),
          ),
          
          // Featured Products
          Container(
            padding: const EdgeInsets.symmetric(vertical: 40, horizontal: 16),
             color: isDark ? null : Colors.white,
            child: Column(
              children: [
                 const Text(
                  "Featured Products",
                  style: TextStyle(
                    fontSize: 28,
                    fontWeight: FontWeight.bold,
                    color: Color(0xFF92400E), // amber-800
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 32),

                if (isLoading)
                  const Center(child: CircularProgressIndicator())
                else
                  GridView.builder(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisCount: isLandscape ? 4 : 2, 
                      mainAxisSpacing: 16,
                      crossAxisSpacing: 16,
                      childAspectRatio: 0.65, // Adjusted to fit content better
                    ),
                    itemCount: featuredProducts.length,
                    itemBuilder: (context, index) {
                      return _buildProductCard(featuredProducts[index], context, isDark);
                    },
                  ),
              ],
            ),
          ),

          // Why Choose Us (Static content features)
          Container(
            width: double.infinity,
            color: Colors.white,
            padding: const EdgeInsets.symmetric(vertical: 50, horizontal: 16),
            child: Column(
              children: [
                const Text(
                  "Why Choose Us",
                  style: TextStyle(
                    fontSize: 26, // Reduced from 32
                    fontWeight: FontWeight.bold,
                    color: Color(0xFF1B1B18),
                  ),
                ),
                const SizedBox(height: 32),
                GridView.count(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    crossAxisCount: isLandscape ? 4 : 2,
                    crossAxisSpacing: 16,
                    mainAxisSpacing: 20,
                    childAspectRatio: 0.72, // Reduced from 0.85 to allow more vertical space
                    children: [
                      _buildWhyChooseUsCard("💡", "Expert Advice", "Our knowledgeable staff is always ready to provide expert advice on equipment that suits your needs.", Colors.amber.shade100, Colors.amber.shade700),
                      _buildWhyChooseUsCard("👍", "Unique Selection", "Explore a diverse range of gym equipment tailored to meet all fitness levels and preferences.", Colors.orange.shade100, Colors.orange.shade700),
                      _buildWhyChooseUsCard("💰", "Competitive Prices", "We offer competitive pricing on all our products, giving you great value without compromising quality.", Colors.green.shade100, Colors.green.shade700),
                      _buildWhyChooseUsCard("🛡️", "Satisfaction Guarantee", "We stand by our products with a satisfaction guarantee, ensuring your investment is protected.", Colors.blue.shade100, Colors.blue.shade700),
                    ],
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

  // Updated Category Card Widget
  Widget _buildCategoryCard(Category category) {
    return Card(
      elevation: 2,
      shadowColor: Colors.black.withOpacity(0.05),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      clipBehavior: Clip.antiAlias, 
      child: InkWell(
        onTap: () => widget.onTabChange(1),
        child: Column(
          children: [
             Expanded(
               flex: 3,
               child: category.image.startsWith('assets/') 
                 ? Image.asset(category.image, fit: BoxFit.cover, width: double.infinity)
                 : Image.network(ApiService.getImageUrl(category.image), fit: BoxFit.cover, width: double.infinity, 
                     errorBuilder: (_, __, ___) => Container(color: Colors.grey[100], child: const Icon(Icons.fitness_center, color: Colors.grey))),
             ),
            Expanded(
              flex: 2,
              child: Container(
                 padding: const EdgeInsets.all(8),
                 color: Colors.white,
                 child: Column(
                   mainAxisAlignment: MainAxisAlignment.center,
                   children: [
                     Text(
                      category.name,
                      textAlign: TextAlign.center,
                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15, color: Color(0xFF1B1B18)),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                     ),
                     const SizedBox(height: 6),
                     Container(
                       padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                       decoration: BoxDecoration(
                         color: const Color(0xFFF3F4F6), // light gray pill
                         borderRadius: BorderRadius.circular(20),
                       ),
                       child: Text(
                        "${category.productCount} Products",
                        style: TextStyle(fontSize: 11, color: Colors.grey.shade700, fontWeight: FontWeight.w500),
                       ),
                     ),
                   ],
                 ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // Updated Product Card Widget
  Widget _buildProductCard(Product product, BuildContext context, bool isDark) {
    return Card(
      elevation: 4,
      shadowColor: Colors.black.withOpacity(0.1),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(
              builder: (context) => ProductDetailsPage(product: product),
            ),
          );
        },
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Expanded(
              flex: 5,
               child: product.image.startsWith('assets/') 
                ? Image.asset(product.image, fit: BoxFit.cover, width: double.infinity)
                : Image.network(ApiService.getImageUrl(product.image), fit: BoxFit.cover, width: double.infinity,
                    errorBuilder: (_, __, ___) => Container(color: Colors.grey[200], child: const Icon(Icons.fitness_center))),
            ),
            Padding(
              padding: const EdgeInsets.all(12),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    product.title,
                    style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16, color: Color(0xFF1B1B18)),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                  Text(
                    "LKR ${product.price}",
                    style: const TextStyle(
                      color: Color(0xFFB45309), // amber-700
                      fontWeight: FontWeight.bold,
                      fontSize: 14,
                    ),
                  ),
                  const SizedBox(height: 12),
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton.icon(
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => ProductDetailsPage(product: product),
                          ),
                        );
                      },
                      icon: const Icon(Icons.shopping_cart, size: 16),
                      label: const Text(
                        "Add to Cart",
                        style: TextStyle(fontSize: 13),
                      ),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: const Color(0xFF10B981), // emerald-500
                        padding: const EdgeInsets.symmetric(vertical: 6),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
                        elevation: 0,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  // Why Choose Us Card
  Widget _buildWhyChooseUsCard(String emoji, String title, String description, Color bgColor, Color iconColor) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10, offset: const Offset(0, 4)),
        ],
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: 54,
            height: 54,
            alignment: Alignment.center,
            decoration: BoxDecoration(color: bgColor, shape: BoxShape.circle),
            child: Text(emoji, style: const TextStyle(fontSize: 28)),
          ),
          const SizedBox(height: 16),
          Text(
            title,
            style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16, color: Color(0xFF1B1B18)),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 8),
          Text(
            description,
            style: TextStyle(fontSize: 12, color: Colors.grey.shade600, height: 1.4),
            textAlign: TextAlign.center,
            maxLines: 4,
            overflow: TextOverflow.ellipsis,
          ),
        ],
      ),
    );
  }
}
