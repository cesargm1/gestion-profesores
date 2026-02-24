import { Component, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HorarioService } from '../../core/services/horario';
import { FaltaService } from '../../core/services/falta';
import { AuthService } from '../../core/services/auth';

@Component({
  standalone: true,
  selector: 'app-profesor',
  imports: [CommonModule, FormsModule],
  templateUrl: './profesor.html',
  styleUrl: './profesor.scss'
})
export class ProfesorComponent {

  horario = signal<any[]>([]);
  recuento = signal<{ dias: number; horas: number }>({ dias: 0, horas: 0 });

  mensaje = signal('');
  tareas = signal('');

  constructor(
    private horarioService: HorarioService,
    private faltaService: FaltaService,
    private auth: AuthService
  ) {
    const alias = this.auth.user()?.alias!;

    this.horarioService.getHorarioHoy(alias)
      .subscribe(data => this.horario.set(data));

    this.faltaService.getRecuento(alias)
      .subscribe(data => this.recuento.set(data));
  }

  faltarTodo() {
    const alias = this.auth.user()?.alias!;

    this.faltaService.registrar({
      profesorAlias: alias,
      fecha: new Date().toISOString(),
      horas: this.horario().length,
      mensaje: this.mensaje(),
      tareas: this.tareas()
    }).subscribe(() => {
      this.faltaService.getRecuento(alias)
        .subscribe(data => this.recuento.set(data));

      this.mensaje.set('');
      this.tareas.set('');
    });
  }
}