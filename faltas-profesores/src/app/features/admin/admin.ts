import { Component, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HorarioService } from '../../core/services/horario';

@Component({
  standalone: true,
  selector: 'app-admin',
  imports: [CommonModule, FormsModule],
  templateUrl: './admin.html',
  styleUrl: './admin.scss'
})
export class AdminComponent {

  horarios = signal<any[]>([]);

  nuevo = {
    profesorAlias: '',
    aula: '',
    horaInicio: '',
    horaFin: '',
    diaSemana: ''
  };

  constructor(private horarioService: HorarioService) {
    this.cargar();
  }

  cargar() {
    this.horarioService.getAll()
      .subscribe(data => this.horarios.set(data));
  }

  crear() {
    this.horarioService.create(this.nuevo)
      .subscribe(() => {
        this.cargar();
        this.nuevo = {
          profesorAlias: '',
          aula: '',
          horaInicio: '',
          horaFin: '',
          diaSemana: ''
        };
      });
  }

  eliminar(id: number) {
    this.horarioService.delete(id)
      .subscribe(() => this.cargar());
  }
}