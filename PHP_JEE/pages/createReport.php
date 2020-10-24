<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/script_craeteReport.js?d=<?php echo time(); ?>"></script>
<style>
    ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
    li { margin: 5px; padding: 5px; width: 150px; }
</style>
<section class="bgcolorApplication p-1 m-0" >
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">Creation rapport</h3>
</section>
<section class="mt-3">

    <div class="container card">
        <div class="row">
            <div class="col-xl-4">
                <div>
                    <form>
                        <label>Rechercher</label>
                        <select class="form-control">
                            <optgroup label="This is a group">
                                <option value="12" selected="">This is item 1</option>
                                <option value="13">This is item 2</option>
                                <option value="14">This is item 3</option>
                            </optgroup>
                        </select>
                        <div role="tablist" id="accordion-1" class="mt-2">
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-1" href="#accordion-1 .item-1">Clients</a></h5>
                                </div>
                                <div class="collapse item-1" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <ul>
                                            <li id="draggable" class="ui-state-highlight mt-1">Code client</li>
                                            <li id="draggable" class="ui-state-highlight mt-1">Nom client</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-2" href="#accordion-1 .item-2">Fournisseurs</a></h5>
                                </div>
                                <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <ul>
                                            <li id="draggable" class="ui-state-highlight mt-1">Code Fournisseur</li>
                                            <li id="draggable" class="ui-state-highlight mt-1">Nom Fournisseur</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true" aria-controls="accordion-1 .item-3" href="#accordion-1 .item-3">Articles</a></h5>
                                </div>
                                <div class="collapse show item-3" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <ul>
                                            <li id="draggable" class="ui-state-highlight mt-1 item"><span id="info">Reference article</span> <span id="supprItem" class="float-right">X</span></li>
                                            <li id="draggable" class="ui-state-highlight mt-1 item"><span id="info">Designation article</span> <span id="supprItem" class="float-right">X</span></li>
                                            <li id="draggable" class="ui-state-highlight mt-1 item"><span id="info">Prix de vente</span> <span id="supprItem" class="float-right">X</span></li>
                                            <li id="draggable" class="ui-state-highlight mt-1 item"><span id="info">Prix d'achat </span><span id="supprItem" class="float-right">X</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true" aria-controls="accordion-1 .item-3" href="#accordion-1 .item-3">Mesure</a></h5>
                                </div>
                                <div class="collapse item-3" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <ul>
                                            <li id="draggable" class="ui-state-highlight mt-1 item"><span id="info">Entree</span> <span id="supprItem" class="float-right">X</span></li>
                                            <li id="draggable" class="ui-state-highlight mt-1 item"><span id="info">Sortie</span> <span id="supprItem" class="float-right">X</span></li>
                                            <li id="draggable" class="ui-state-highlight mt-1 item"><span id="info">CA HT</span> <span id="supprItem" class="float-right">X</span></li>
                                            <li id="draggable" class="ui-state-highlight mt-1 item"><span id="info">CA TTC</span><span id="supprItem" class="float-right">X</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col">
                <label>Filtre :</label>
                <div id="listFilter">
                    <div id="filter" class="row">
                        <select id="selection" class="col-5 form-control">
                            <option value=""></option>
                            <option value="date">Date</option>
                            <option value="client">Client</option>
                            <option value="fournisseur">Fournisseur</option>
                            <option value="article">Article</option>
                        </select>
                        <input id="item1" type="text" class="ml-2 col-3 form-control"/>
                        <input id="item2" type="text" class="ml-2 col-3 form-control"/>
                        <span class="ml-2"><i id="removeFilter" class="fas fa-close" style="color:red;font-size: 25px"></i></span>
                    </div>
                </div>
                <div class="col">
                    <i id="addFilter" class="fas fa-plus-circle"></i>
                </div>
                <div class="card p-3 m-3 h-75">
                    Placer vos colonnes ici
                    <ul class="h-100 w-100"id="sortable">
                    </ul>
                </div>
                <div>
                    <input type="button" id="valider" class="btn btn-primary w-100" value="valider" />
                </div>
            </div>
        </div>
    </div>
    <div id="result" class="container mt-3">

    </div>

</section>