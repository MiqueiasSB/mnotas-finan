<div wire:ignore>
    @script
        <script>
            $wire.on('criaModalView', (categoria) => {

                categoria = categoria[0];

                document.getElementById('tituloViewModal').innerText = categoria.tipo;
                document.getElementById('tipoExcluido').innerText = categoria.tipo;

                document.getElementById('nomeCategoria').value = categoria.nome;

                document.getElementById('btnViewCategoriaT').click();
            });

            $wire.on('fecharViewModal', () => {
                // Aciona o clique no botão usando JavaScript
                document.getElementById('fecharViewModal').click();
            });
        </script>
    @endscript

    <button id="btnViewCategoriaT" class="d-none" data-bs-toggle="modal" data-bs-target="#viewCategoriaT">Abrir</button>


    <!-- Modal -->
    <div class="modal fade" id="viewCategoriaT" tabindex="-1" aria-labelledby="tituloViewModal" aria-hidden="true"
        x-data="{ alerta: false }">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tituloViewModal"></h1>
                    <button id="fecharViewModal" type="button" x-on:click="alerta = false" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    @if ($errors->any())
                        <div class="col-12">
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="col">
                        <input x-bind:disabled="alerta" id="nomeCategoria" wire:model="nome" type="text"
                            class="form-control text-capitalize" placeholder="Nome da Categoria">
                    </div>


                </div>
                <div class="modal-footer">

                    {{-- Funcionamento normal --}}
                    <div x-show="!alerta">
                        <button type="button" class="btn btn-danger" x-on:click="alerta = true"><i
                                class="bi bi-trash-fill"></i> Excluir</button>
                        <button type="submit" class="btn btn-primary" wire:click="update()"><i class="bi bi-check"></i>
                            Salvar</button>
                    </div>

                    {{-- Aviso de alerta ao tentar excluir --}}
                    <div x-show="alerta">
                        <small class="text-danger w-100">

                            <p><i class="text-start bi bi-info-circle-fill"></i> Para não perder as estatisticas
                                referêntes
                                a essa categoria é recomendado não exclui-la e sim editar o seu nome.</p>

                            <p>Ao excluir uma categoria, todas as transações pertencentes a ela serão consideradas como
                                uma categoria genêrica referênte ao seu tipo
                                ( <span id="tipoExcluido"></span> )
                            </p>
                            <strong>Deseja excluir esta categoria?</strong>
                        </small>

                        <div class="text-end">
                            <button type="button" class="btn btn-danger" wire:click="destroy()"><i
                                    class="bi bi-trash-fill"></i> Excluir</button>
                            <button type="submit" class="btn btn-dark text-light" x-on:click="alerta = false"
                                data-bs-dismiss="modal" aria-label="Close">
                                Não</button>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <x-loading></x-loading>
    </div>

</div>
