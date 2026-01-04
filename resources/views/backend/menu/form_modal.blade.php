<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">{{ $form_title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form id="dataForm" class="form" method="POST" action="{{ route('menu.store') }}">
            @csrf
            <div class="modal-body m-3">
               <input type="hidden" id="id" name="id" />



               <div class="row">
                  <div class="form-group">
                     <label>Module Name <sup class="text-danger">*</sup></label>
                     <input type="text" class="form-control" id="modulename" name="modulename"
                        placeholder="Enter Module Name" />
                  </div>
               </div>
               <div class="row">
                  <div class="form-group">
                     <label>Parent Menu <sup class="text-danger">*</sup></label>
                     <select class="form-select" id="parentmoduleid" name="parentmoduleid">
                        <option value="0">-----------</option>
                        @foreach($menu as $li)
                        <option value="{{$li->id}}">{{$li->modulename}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="form-group">
                     <label>Web Url <sup class="text-danger">*</sup></label>
                     <input type="text" class="form-control" id="url" name="url" placeholder="Enter url" />
                  </div>
               </div>

               <div class="row">
                  <div class="form-group">
                     <label>Icon <sup class="text-danger">*</sup></label>
                     <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter Icon code"
                        value="fas fa-" />
                  </div>
               </div>

               <div class="row">
                  <div class="form-group">
                     <label>Orderby <sup class="text-danger">*</sup></label>
                     <input type="number" class="form-control" id="orderby" name="orderby"
                        placeholder="Enter Ordering" />
                  </div>
               </div>


            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-close"></i>
                  Close</button>
               <button type="submit" id="btnSubmit" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
               <button type="submit" id="btnUpdate" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </div>
         </form>
      </div>
   </div>
</div>