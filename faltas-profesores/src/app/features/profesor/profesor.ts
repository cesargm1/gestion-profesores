import { Component, computed, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HorarioService } from '../../core/services/horario';
import { FaltaService } from '../../core/services/falta';
import { AuthService } from '../../core/services/auth';
import { Horario } from '../../models/horario.model';

@Component({
  standalone: true,
  selector: 'app-profesor',
  imports: [CommonModule, FormsModule],
  templateUrl: './profesor.html',
  styleUrl: './profesor.scss'
})
export class ProfesorComponent {

  horario = signal<Horario[]>([]);
  recuento = signal<{ dias: number; horas: number }>({ dias: 0, horas: 0 });

  slots = [
    { horaInicio: '15:20', horaFin: '16:15' },
    { horaInicio: '16:15', horaFin: '17:10' },
    { horaInicio: '17:10', horaFin: '18:05' },
    { horaInicio: '18:25', horaFin: '19:20' },
    { horaInicio: '19:20', horaFin: '20:15' },
    { horaInicio: '20:15', horaFin: '21:10' },
    { horaInicio: '21:10', horaFin: '22:05' }
  ];

  filasHorario = computed(() =>
    this.slots.map(slot => ({
      slot,
      clase:
        this.horario().find(
          h =>
            h.horaInicio === slot.horaInicio &&
            h.horaFin === slot.horaFin
        ) ?? null
    }))
  );

  // Panel de falta por clase seleccionada
  claseSeleccionada = signal<Horario | null>(null);
  mensajeHora = signal('');
  tareasHora = signal('');

  // Panel de falta de todo el día
  mensajeDia = signal('');
  tareasDia = signal('');

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

  seleccionarClase(h: Horario) {
    this.claseSeleccionada.set(h);
    this.mensajeHora.set('');
    this.tareasHora.set('');
  }

  faltarClase() {
    const clase = this.claseSeleccionada();
    if (!clase) return;

    const alias = this.auth.user()?.alias!;

    this.faltaService.registrar({
      profesorAlias: alias,
      fecha: new Date().toISOString(),
      horas: 1,
      mensaje: this.mensajeHora(),
      tareas: this.tareasHora()
    }).subscribe(() => {
      this.faltaService.getRecuento(alias)
        .subscribe(data => this.recuento.set(data));

      this.claseSeleccionada.set(null);
      this.mensajeHora.set('');
      this.tareasHora.set('');
    });
  }

  faltarTodo() {
    const alias = this.auth.user()?.alias!;

    this.faltaService.registrar({
      profesorAlias: alias,
      fecha: new Date().toISOString(),
      horas: this.horario().length,
      mensaje: this.mensajeDia(),
      tareas: this.tareasDia()
    }).subscribe(() => {
      this.faltaService.getRecuento(alias)
        .subscribe(data => this.recuento.set(data));

      this.mensajeDia.set('');
      this.tareasDia.set('');
    });
  }
}