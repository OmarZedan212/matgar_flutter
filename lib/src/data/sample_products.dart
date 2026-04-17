import '../models/product.dart';

const sampleProducts = <Product>[
  Product(
    id: 1,
    name: 'Everyday Backpack',
    category: 'Bags',
    price: 64.99,
    description: 'Roomy, durable, and ready for work or travel.',
    imageUrl:
        'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=900&q=80',
    isFeatured: true,
  ),
  Product(
    id: 2,
    name: 'Wireless Headphones',
    category: 'Electronics',
    price: 119.00,
    description: 'Clean sound, soft ear cups, and all-day battery life.',
    imageUrl:
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80',
    isFeatured: true,
  ),
  Product(
    id: 3,
    name: 'Running Sneakers',
    category: 'Shoes',
    price: 89.50,
    description: 'Lightweight trainers with breathable mesh.',
    imageUrl:
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80',
  ),
  Product(
    id: 4,
    name: 'Cotton Hoodie',
    category: 'Fashion',
    price: 48.75,
    description: 'Soft fleece hoodie with a relaxed fit.',
    imageUrl:
        'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=900&q=80',
  ),
];
