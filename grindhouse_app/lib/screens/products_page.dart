import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:grindhouse_app/screens/products_details.dart';
import 'package:grindhouse_app/screens/product_model.dart';
import 'package:grindhouse_app/screens/cart_provider.dart';
import 'package:grindhouse_app/services/api_service.dart';
import 'package:grindhouse_app/components/footer.dart';

class ProductsPage extends StatefulWidget {
  const ProductsPage({super.key});

  @override
  State<ProductsPage> createState() => _ProductsPageState();
}

class _ProductsPageState extends State<ProductsPage> {
  String selectedCategory = "All Products";
  bool isLoading = true;
  final TextEditingController _searchController = TextEditingController();
  String searchQuery = "";

  // These will be populated from the database
  List<String> categories = ["All Products"]; 
  List<Product> allProducts = [];

  @override
  void initState() {
    super.initState();
    _fetchData();
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  Future<void> _fetchData() async {
    setState(() => isLoading = true);
    
    try {
      // Fetch both products and categories in parallel
      final results = await Future.wait([
        ApiService.getProducts(),
        ApiService.getCategories(),
      ]);

      final productData = results[0] as List<dynamic>?;
      final categoryData = results[1] as List<dynamic>?;

      if (mounted) {
        setState(() {
          if (productData != null) {
            allProducts = productData.map((json) => Product.fromJson(json)).toList();
          }
          
          if (categoryData != null && categoryData.isNotEmpty) {
            // Get category names from the dedicated categories endpoint
            categories = ["All Products", ...categoryData.map((c) => c['name'].toString())];
          } else {
            // Fallback to deriving from products if categories fetch fails or is empty
            final fetchedCategories = allProducts
                .map((p) => p.category ?? "Uncategorized")
                .where((c) => c.isNotEmpty)
                .toSet()
                .toList();
            categories = ["All Products", ...fetchedCategories];
          }
          
          isLoading = false;
        });
      }
    } catch (e) {
      debugPrint("Error fetching products or categories: $e");
      if (mounted) {
        setState(() => isLoading = false);
      }
    }
  }

  List<Product> get filteredProducts {
    List<Product> results = allProducts;
    
    // Filter by Category
    if (selectedCategory != "All Products") {
      results = results.where((product) => product.category == selectedCategory).toList();
    }
    
    // Filter by Search Query
    if (searchQuery.isNotEmpty) {
      results = results.where((product) => 
        product.title.toLowerCase().contains(searchQuery.toLowerCase())
      ).toList();
    }
    
    return results;
  }

  void _showCategoryMenu(BuildContext context) async {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    final RenderBox button = context.findRenderObject() as RenderBox;
    final overlay = Overlay.of(context).context.findRenderObject() as RenderBox;

    final RelativeRect position = RelativeRect.fromRect(
      Rect.fromPoints(
        button.localToGlobal(Offset.zero, ancestor: overlay),
        button.localToGlobal(button.size.bottomRight(Offset.zero),
            ancestor: overlay),
      ),
      Offset.zero & overlay.size,
    );

    final String? value = await showMenu<String>(
      context: context,
      position: position,
      constraints: BoxConstraints(
        minWidth: button.size.width,
      ),
      color: isDark ? const Color(0xFF2D2D2D) : Colors.white,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
      items: categories.map((String category) {
        return PopupMenuItem<String>(
          value: category,
          padding: const EdgeInsets.symmetric(horizontal: 12),
          height: 48,
          child: Text(
            category,
            style: TextStyle(
              fontSize: 16,
              fontWeight: category == selectedCategory
                  ? FontWeight.bold
                  : FontWeight.normal,
              color: category == selectedCategory
                  ? const Color(0xFFB45309) // amber-700
                  : (isDark ? Colors.white : Colors.black87),
            ),
          ),
        );
      }).toList(),
      elevation: 8,
    );

    if (value != null) {
      setState(() {
        selectedCategory = value;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    final mediaQuery = MediaQuery.of(context);
    final isLandscape = mediaQuery.orientation == Orientation.landscape;
    
    return Scaffold(
      backgroundColor: isDark ? const Color(0xFF1B1B18) : Colors.white,
      body: isLoading 
        ? const Center(child: CircularProgressIndicator())
        : SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Top Search Bar
                Padding(
                  padding: const EdgeInsets.only(top: 20, left: 16, right: 16, bottom: 10),
                  child: Container(
                    decoration: BoxDecoration(
                      color: isDark ? const Color(0xFF2D2D2D) : Colors.white,
                      borderRadius: BorderRadius.circular(8),
                      border: Border.all(color: Colors.grey.shade300),
                    ),
                    child: TextField(
                      controller: _searchController,
                      onChanged: (value) {
                        setState(() {
                          searchQuery = value;
                        });
                      },
                      decoration: const InputDecoration(
                        hintText: "Search products...",
                        prefixIcon: Icon(Icons.search, color: Colors.grey),
                        border: InputBorder.none,
                        contentPadding: EdgeInsets.symmetric(vertical: 12),
                      ),
                    ),
                  ),
                ),

                // Category Selector Card
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
                  child: Container(
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: isDark ? const Color(0xFF2D2D2D) : Colors.white,
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(color: Colors.orange.shade100),
                    ),
                    child: Row(
                      children: [
                        const Icon(Icons.menu, color: Color(0xFF92400E)), // amber-800
                        const SizedBox(width: 8),
                        const Text(
                          "Category",
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 16,
                            color: Color(0xFF92400E),
                          ),
                        ),
                        const Spacer(),
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                          decoration: BoxDecoration(
                            border: Border.all(color: Colors.grey.shade300),
                            borderRadius: BorderRadius.circular(8),
                          ),
                          child: Builder(
                            builder: (buttonContext) => InkWell(
                              onTap: () => _showCategoryMenu(buttonContext),
                              child: Row(
                                children: [
                                  Text(
                                    selectedCategory,
                                    style: TextStyle(
                                      color: isDark ? Colors.white : Colors.black87,
                                      fontSize: 16,
                                      fontWeight: FontWeight.w500,
                                    ),
                                  ),
                                  const Icon(Icons.arrow_drop_down),
                                ],
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),

                // Section Title: All Fitness Equipment
                const Padding(
                  padding: EdgeInsets.symmetric(horizontal: 16, vertical: 20),
                  child: Text(
                    "All Fitness Equipment",
                    style: TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF92400E), // amber-800
                    ),
                  ),
                ),

                // Product Grid
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: filteredProducts.isEmpty
                      ? Center(
                          child: Padding(
                            padding: const EdgeInsets.all(40.0),
                            child: Column(
                              children: [
                                Icon(Icons.inventory_2_outlined, size: 64, color: Colors.grey.shade400),
                                const SizedBox(height: 16),
                                const Text("No products found"),
                              ],
                            ),
                          ),
                        )
                      : GridView.builder(
                          shrinkWrap: true,
                          physics: const NeverScrollableScrollPhysics(),
                          gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                            crossAxisCount: isLandscape ? 4 : 2,
                            mainAxisSpacing: 16,
                            crossAxisSpacing: 16,
                            childAspectRatio: 0.65, 
                          ),
                          itemCount: filteredProducts.length,
                          itemBuilder: (context, index) {
                            final product = filteredProducts[index];
                            return _buildProductCard(product, context, isDark, isLandscape);
                          },
                        ),
                ),

                const SizedBox(height: 40),
                
                // Footer
                const Footer(),
              ],
            ),
          ),
    );
  }

  Widget _buildProductCard(Product product, BuildContext context, bool isDark, bool isLandscape) {
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
              child: Image.network(
                ApiService.getImageUrl(product.image),
                fit: BoxFit.cover,
                width: double.infinity,
                errorBuilder: (_, __, ___) => Container(
                  color: Colors.grey[200],
                  child: const Icon(Icons.fitness_center),
                ),
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(12),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    product.title,
                    style: const TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                      color: Color(0xFF1B1B18),
                    ),
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
}
