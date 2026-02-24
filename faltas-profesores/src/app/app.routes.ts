import { Routes } from '@angular/router';
import { LoginComponent } from './features/auth/login/login';
import { ProfesorComponent } from './features/profesor/profesor';
import { AdminComponent } from './features/admin/admin';
import { authGuard } from './core/guards/auth-guard';
import { adminGuard } from './core/guards/admin-guard';

export const routes: Routes = [
  { path: '', component: LoginComponent },
  { path: 'peremaria', component: ProfesorComponent, canActivate: [authGuard] },
  { path: 'admin', component: AdminComponent, canActivate: [authGuard, adminGuard] },
  { path: '**', redirectTo: '' }
];