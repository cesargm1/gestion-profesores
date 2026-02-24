import { Injectable, signal, computed } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap } from 'rxjs';
import { User } from '../../models/user.model';

@Injectable({ providedIn: 'root' })
export class AuthService {

  private _user = signal<User | null>(null);
  user = computed(() => this._user());
  isAdmin = computed(() => this._user()?.role === 'admin');

  private API = 'http://localhost:8080/api/auth';

  constructor(private http: HttpClient) {}

  login(alias: string): Observable<User> {
    return this.http.post<User>(`${this.API}/login`, { alias })
      .pipe(tap(user => this._user.set(user)));
  }

  logout() {
    this._user.set(null);
  }
}