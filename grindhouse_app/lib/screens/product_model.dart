class Product {
  final int? id;
  final String title;
  final String price;
  final String image;
  final String? description;
  final String? category;

  Product({
    this.id,
    required this.title,
    required this.price,
    required this.image,
    this.description,
    this.category,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'],
      title: json['name'] ?? 'No Title',
      price: json['price']?.toString() ?? '0.00',
      image: json['image'] ?? '',
      description: json['description'],
      category: json['category']?['name'],
    );
  }
}
