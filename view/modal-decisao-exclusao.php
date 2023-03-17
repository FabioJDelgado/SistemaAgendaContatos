<div class="modal fade" id="modalDecisaoExclusao" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalDecisaoExclusaoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header cor-vermelha">
                <h5 class="modal-title cor-branca">SisAg</h5>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>-->
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir o contato?</p>
                <input type="number" id="idContatoDel" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-secondary" onclick="excluirContato()">Sim</button>
            </div>
        </div>
    </div>
</div>