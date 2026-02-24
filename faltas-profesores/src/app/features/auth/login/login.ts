import { Component, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../../core/services/auth';

@Component({
  standalone: true,
  selector: 'app-login',
  imports: [CommonModule, FormsModule],
  templateUrl: './login.html',
  styleUrl: './login.scss'
})
export class LoginComponent {

  alias = signal('');
  loading = signal(false);
  error = signal('');

  constructor(private auth: AuthService, private router: Router) {}

  login() {
    if (!this.alias()) {
      this.error.set('Introduce un alias');
      return;
    }

    this.loading.set(true);
    this.error.set('');

    this.auth.login(this.alias()).subscribe({
      next: user => {
        this.loading.set(false);
        user.role === 'admin'
          ? this.router.navigate(['/admin'])
          : this.router.navigate(['/peremaria']);
      },
      error: () => {
        this.loading.set(false);
        this.error.set('Alias incorrecto');
      }
    });
  }
}