import 'package:flutter/material.dart';

import '../state/session_controller.dart';

class AccountScreen extends StatefulWidget {
  const AccountScreen({
    super.key,
    required this.session,
  });

  final SessionController session;

  @override
  State<AccountScreen> createState() => _AccountScreenState();
}

class _AccountScreenState extends State<AccountScreen> {
  final nameController = TextEditingController();
  final emailController = TextEditingController();
  final passwordController = TextEditingController();
  bool isRegistering = false;

  @override
  void dispose() {
    nameController.dispose();
    emailController.dispose();
    passwordController.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    FocusScope.of(context).unfocus();

    if (isRegistering) {
      await widget.session.register(
        name: nameController.text.trim(),
        email: emailController.text.trim(),
        password: passwordController.text,
      );
    } else {
      await widget.session.login(
        email: emailController.text.trim(),
        password: passwordController.text,
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Account')),
      body: ListenableBuilder(
        listenable: widget.session,
        builder: (context, _) {
          final session = widget.session;

          return ListView(
            padding: const EdgeInsets.all(16),
            children: [
              if (session.isSignedIn)
                _SignedInCard(session: session)
              else
                _AuthCard(
                  isRegistering: isRegistering,
                  isLoading: session.isLoading,
                  errorMessage: session.errorMessage,
                  nameController: nameController,
                  emailController: emailController,
                  passwordController: passwordController,
                  onSubmit: _submit,
                  onModeChanged: () {
                    setState(() => isRegistering = !isRegistering);
                  },
                ),
              const SizedBox(height: 16),
              const ListTile(
                leading: Icon(Icons.receipt_long_outlined),
                title: Text('Orders'),
                subtitle: Text('Track purchases and invoices'),
              ),
              const ListTile(
                leading: Icon(Icons.location_on_outlined),
                title: Text('Addresses'),
                subtitle: Text('Manage delivery information'),
              ),
              const ListTile(
                leading: Icon(Icons.support_agent_outlined),
                title: Text('Support'),
                subtitle: Text('Contact the store team'),
              ),
            ],
          );
        },
      ),
    );
  }
}

class _AuthCard extends StatelessWidget {
  const _AuthCard({
    required this.isRegistering,
    required this.isLoading,
    required this.nameController,
    required this.emailController,
    required this.passwordController,
    required this.onSubmit,
    required this.onModeChanged,
    this.errorMessage,
  });

  final bool isRegistering;
  final bool isLoading;
  final String? errorMessage;
  final TextEditingController nameController;
  final TextEditingController emailController;
  final TextEditingController passwordController;
  final VoidCallback onSubmit;
  final VoidCallback onModeChanged;

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: EdgeInsets.zero,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              isRegistering ? 'Create account' : 'Welcome back',
              style: Theme.of(context).textTheme.headlineSmall,
            ),
            const SizedBox(height: 8),
            const Text('Use your Laravel customer account.'),
            const SizedBox(height: 16),
            if (isRegistering) ...[
              TextField(
                controller: nameController,
                autofillHints: const [AutofillHints.name],
                decoration: const InputDecoration(
                  border: OutlineInputBorder(),
                  labelText: 'Name',
                ),
              ),
              const SizedBox(height: 12),
            ],
            TextField(
              controller: emailController,
              autofillHints: const [AutofillHints.email],
              keyboardType: TextInputType.emailAddress,
              decoration: const InputDecoration(
                border: OutlineInputBorder(),
                labelText: 'Email',
              ),
            ),
            const SizedBox(height: 12),
            TextField(
              controller: passwordController,
              autofillHints: const [AutofillHints.password],
              obscureText: true,
              decoration: const InputDecoration(
                border: OutlineInputBorder(),
                labelText: 'Password',
              ),
            ),
            if (errorMessage != null) ...[
              const SizedBox(height: 12),
              Text(
                errorMessage!,
                style: TextStyle(color: Theme.of(context).colorScheme.error),
              ),
            ],
            const SizedBox(height: 16),
            SizedBox(
              width: double.infinity,
              child: FilledButton(
                onPressed: isLoading ? null : onSubmit,
                child: Text(isRegistering ? 'Create account' : 'Sign in'),
              ),
            ),
            TextButton(
              onPressed: isLoading ? null : onModeChanged,
              child: Text(
                isRegistering
                    ? 'I already have an account'
                    : 'Create a customer account',
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _SignedInCard extends StatelessWidget {
  const _SignedInCard({required this.session});

  final SessionController session;

  @override
  Widget build(BuildContext context) {
    final user = session.user!;

    return Card(
      margin: EdgeInsets.zero,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              user.name,
              style: Theme.of(context).textTheme.headlineSmall,
            ),
            const SizedBox(height: 4),
            Text(user.email),
            if (user.phone != null) Text(user.phone!),
            if (user.address != null) Text(user.address!),
            const SizedBox(height: 16),
            OutlinedButton(
              onPressed: session.isLoading ? null : session.logout,
              child: const Text('Sign out'),
            ),
          ],
        ),
      ),
    );
  }
}
