import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Falta } from '../../models/falta.model';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class FaltaService {

  private API = 'http://localhost:8080/api/faltas';

  constructor(private http: HttpClient) {}

  registrar(f: Falta): Observable<Falta> {
    return this.http.post<Falta>(this.API, f);
  }

  getRecuento(alias: string): Observable<{ dias: number; horas: number }> {
    return this.http.get<{ dias: number; horas: number }>(
      `${this.API}/recuento/${alias}`
    );
  }
}