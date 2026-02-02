import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:grindhouse_app/components/starter_wrapper.dart';
import 'package:grindhouse_app/screens/cart_provider.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (context) => CartProvider(),
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'GrindHouse',

        // 🌗 Automatically follows device theme
        themeMode: ThemeMode.system,

        // 🌞 LIGHT THEME
        theme: ThemeData(
          brightness: Brightness.light,
          colorScheme: ColorScheme.fromSeed(
            seedColor: Colors.amber,
            primary: const Color(0xFFD97706), // amber-600
            secondary: const Color(0xFFB45309), // amber-700
            surface: Colors.white,
            background: Colors.white, 
            brightness: Brightness.light,
          ),
          scaffoldBackgroundColor: Colors.white,
          appBarTheme: const AppBarTheme(
            backgroundColor: Colors.white,
            elevation: 0,
            titleTextStyle: TextStyle(
              color: Color(0xFFB45309), // amber-700
              fontWeight: FontWeight.bold,
              fontSize: 22,
            ),
            iconTheme: IconThemeData(color: Color(0xFFB45309)),
            shape: Border(bottom: BorderSide(color: Color(0xFFE3E3E0), width: 1)),
          ),
          cardTheme: CardThemeData(
            color: Colors.white,
            elevation: 2,
            shadowColor: Colors.black.withOpacity(0.1),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
              side: const BorderSide(color: Color(0xFFE3E3E0), width: 1),
            ),
          ),
          textTheme: const TextTheme(
            bodyMedium: TextStyle(color: Color(0xFF1B1B18), fontSize: 16),
            titleLarge: TextStyle(color: Color(0xFF1B1B18), fontWeight: FontWeight.bold),
          ),
          elevatedButtonTheme: ElevatedButtonThemeData(
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFFD97706),
              foregroundColor: Colors.white,
              textStyle: const TextStyle(fontWeight: FontWeight.bold),
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
              ),
            ),
          ),
          bottomNavigationBarTheme: const BottomNavigationBarThemeData(
            backgroundColor: Colors.white,
            selectedItemColor: Color(0xFFD97706),
            unselectedItemColor: Color(0xFF706F6C),
            elevation: 8,
          ),
        ),

        // 🌙 DARK THEME
        darkTheme: ThemeData(
          brightness: Brightness.dark,
          colorScheme: ColorScheme.fromSeed(
            seedColor: Colors.amber,
            primary: const Color(0xFFD97706),
            secondary: const Color(0xFFB45309),
            brightness: Brightness.dark,
          ),
          scaffoldBackgroundColor: const Color(0xFF111111),
          appBarTheme: const AppBarTheme(
            backgroundColor: Color(0xFF1A1A1A),
            elevation: 0,
            titleTextStyle: TextStyle(
              color: Colors.amber,
              fontWeight: FontWeight.bold,
              fontSize: 22,
            ),
            iconTheme: IconThemeData(color: Colors.amber),
          ),
          cardTheme: CardThemeData(
            color: const Color(0xFF1A1A1A),
            elevation: 4,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
              side: BorderSide(color: Colors.white.withOpacity(0.1)),
            ),
          ),
          textTheme: const TextTheme(
            bodyMedium: TextStyle(color: Colors.white70, fontSize: 16),
            titleLarge: TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
          ),
          elevatedButtonTheme: ElevatedButtonThemeData(
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color.fromARGB(255, 165, 55, 15),
              foregroundColor: Colors.white,
              textStyle: const TextStyle(fontWeight: FontWeight.bold),
              shape: const RoundedRectangleBorder(
                borderRadius: BorderRadius.all(Radius.circular(10)),
              ),
            ),
          ),
          bottomNavigationBarTheme: const BottomNavigationBarThemeData(
            backgroundColor: Color(0xFF2D2D2D),
            selectedItemColor: Color.fromARGB(255, 238, 184, 113),
            unselectedItemColor: Colors.grey,
          ),
          inputDecorationTheme: InputDecorationTheme(
            filled: true,
            fillColor: const Color(0xFF2D2D2D),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide: const BorderSide(color: Colors.grey),
            ),
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide: const BorderSide(
                color: Color.fromARGB(255, 238, 184, 113),
                width: 2,
              ),
            ),
          ),
        ),

        // 🏠 Main screen
        home: const Wrapper(),
      ),
    );
  }
}