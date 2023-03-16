<div class="modal fade" id="modalEditarContato" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalEditarContatoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Editar Contato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-atualiza-contato" id="formAtualizaContato">
                    <div class="form-group">
                        <label for="nomeAtt">Nome</label>
                        <input type="text" class="form-control" id="nomeAtt" name="nomeAtt" required="true">
                    </div>
                    <div class="form-group">
                        <label for="telefoneAtt">Telefone</label>
                        <input type="text" class="form-control" id="telefoneAtt" name="telefoneAtt" required="true">
                    </div>
                    <div class="form-group">
                        <label for="emailAtt">E-mail</label>
                        <input type="email" class="form-control" id="emailAtt" name="emailAtt" required="true">
                    </div>
                    <div class="form-grupo" id="divFotoAtual">
                        <label for="fotoAtualAtt">Foto Atual</label>
                        <img alt="" id="fotoAtualAtt" width="75" height="75">
                    </div>
                    <div class="form-group" id="divNovaFoto">
                        <label for="fotoAtt">Escolher nova foto</label>
                        <input type="file" class="form-control input-file" id="fotoAtt" name="fotoAtt" accept="image/png,image/jpeg,image/jpg">
                    </div>
                    <input hidden type="text" name="_acao" value="editar">
                    <input hidden type="number" name="idContatoAtt" id="idContatoAtt">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="atualizaContato">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>