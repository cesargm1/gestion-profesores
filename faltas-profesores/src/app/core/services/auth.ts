import { Injectable, signal, computed } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap, of, throwError } from 'rxjs';
import { User } from '../../models/user.model';
import { delay } from 'rxjs/operators';

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
  // login(alias: string): Observable<User> {
  //   const a = alias.trim().toUpperCase();
  //   if (!a) return throwError(() => new Error('Alias vacío'));

  //   const user: User =
  //     a === 'ADMIN'
  //       ? { id: 1, alias: a, role: 'admin' }
  //       : { id: 2, alias: a, role: 'profesor' };

  //   return of(user).pipe(
  //     delay(400),
  //     tap((u) => this._user.set(u))
  //   );
  // }

  logout() {
    this._user.set(null);
  }
}