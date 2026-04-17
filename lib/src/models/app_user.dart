class AppUser {
  const AppUser({
    required this.id,
    required this.name,
    required this.email,
    this.phone,
    this.address,
    this.dob,
    this.gender,
  });

  final int id;
  final String name;
  final String email;
  final String? phone;
  final String? address;
  final String? dob;
  final String? gender;

  factory AppUser.fromJson(Map<String, dynamic> json) {
    return AppUser(
      id: json['id'] as int,
      name: json['name'] as String? ?? '',
      email: json['email'] as String? ?? '',
      phone: json['phone'] as String?,
      address: json['address'] as String?,
      dob: json['dob'] as String?,
      gender: json['gender'] as String?,
    );
  }
}
