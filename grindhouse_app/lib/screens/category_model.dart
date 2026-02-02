class Category {
  final String id;
  final String name;
  final String image;
  final int productCount;

  Category({
    required this.id,
    required this.name,
    required this.image,
    this.productCount = 0,
  });

  factory Category.fromJson(Map<String, dynamic> json) {
    return Category(
      id: json['id'].toString(),
      name: json['name'] ?? 'Unnamed',
      image: json['image'] ?? '',
      productCount: json['products_count'] ?? 0,
    );
  }
}
