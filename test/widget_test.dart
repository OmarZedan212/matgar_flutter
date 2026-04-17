import 'package:flutter_test/flutter_test.dart';

import 'package:matgar/src/app.dart';

void main() {
  testWidgets('Matgar shop opens without default products', (WidgetTester tester) async {
    await tester.pumpWidget(const MatgarApp());

    expect(find.text('Matgar'), findsOneWidget);
    expect(find.text('All products'), findsOneWidget);
    expect(find.text('Everyday Backpack'), findsNothing);
  });

  testWidgets('Orders tab asks user to sign in', (WidgetTester tester) async {
    await tester.pumpWidget(const MatgarApp());

    await tester.tap(find.text('Orders'));
    await tester.pump();

    expect(find.text('Sign in to track orders'), findsOneWidget);
  });
}
