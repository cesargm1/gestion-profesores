import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Horario } from '../../models/horario.model';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class HorarioService {

  private API = 'http://localhost:8080/api/horarios';

  constructor(private http: HttpClient) {}

  getHorarioHoy(alias: string): Observable<Horario[]> {
    return this.http.get<Horario[]>(`${this.API}/hoy/${alias}`);
  }

  getAll(): Observable<Horario[]> {
    return this.http.get<Horario[]>(this.API);
  }

  create(h: Horario): Observable<Horario> {
    return this.http.post<Horario>(this.API, h);
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.API}/${id}`);
  }
}