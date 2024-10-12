<x-caixa bodyClass="h-100">
    <div class="row ">

        <div class="col-12 mb-3">
            <h4>Horario de Trabalho</h4>
        </div>
 
        <div class="col">
            <label for="limiteInicial">Hora Inicial</label>
            <select wire:model.live="limiteInicial" class="form-control form-control-lg" name="limiteInicial"
                id="limiteInicial">

                @for ($hour = 0; $hour < $this->limiteFinal; $hour++)
                    @php
                        $formattedHourInicial = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                    @endphp
                    <option wire:key="horaF_{{ $hour }}" value="{{ $hour }}">{{ $formattedHourInicial }}
                    </option>
                @endfor

            </select>
        </div>

        <div class="col"> 
            <label for="limiteFinal">Hora Final</label>
            <select wire:model.live="limiteFinal" class="form-control form-control-lg" name="limiteFinal"
                id="limiteFinal">
                @for ($hourF = $this->limiteInicial + 1; $hourF < 24; $hourF++)
                    @php
                        $formattedHourFinal = str_pad($hourF, 2, '0', STR_PAD_LEFT) . ':00';
                    @endphp
                    <option wire:key="horaF_{{ $hourF }}" value="{{ $hourF }}">{{ $formattedHourFinal }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</x-caixa>
