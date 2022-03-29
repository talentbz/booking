<?php
$layout = (!empty($layout)) ? $layout : 'col-12';
$idName = str_replace(['[', ']'], '_', $id);
?>
<div id="setting-{{ $idName }}" data-condition="{{ $condition }}"
     data-unique="{{ $unique }}"
     data-operator="{{ $operation }}"
     class="form-group mb-3 col {{ $layout }} field-{{ $type }}">
    <?php
    $tab_title = get_payment_options('title');
    $tab_content = get_payment_options('content');
    ?>
    <div class="col col-12">
        <ul class="nav nav-tabs nav-bordered">
            @foreach ($tab_title as $__key => $title)
                <?php $class = ($__key == 0) ? 'active show' : ''; ?>
                <li class="nav-item">
                    <a href="#{{ $title['id'] }}"
                       data-toggle="tab"
                       aria-expanded="false"
                       class="nav-link {{ $class }}">
                        {{ $title['label'] }}
                    </a>
                </li>
            @endforeach
            
            <li class="nav-item">
                    <a href="#wspay"
                       data-toggle="tab"
                       aria-expanded="false"
                       class="nav-link wspay">
                        Wspay
                    </a>
                </li>
        </ul>
        <div class="tab-content">
            @foreach ($tab_title as $__key => $title)
                <?php $class = ($__key == 0) ? 'active show' : ''; ?>
                <div class="tab-pane {{ $class }}"
                     id="{{ $title['id'] }}">
                    <div class="row">
                        @foreach ($tab_content as $___key => $content)
                            <?php
                        
                            if ($content['section'] == $title['id']) {
                                $currentOptions[] = $content;
                                $content['value'] = \ThemeOptions::getOption($content['id'], '', true);
                                $content = \ThemeOptions::mergeField($content);
                                echo \ThemeOptions::loadField($content);
                            }
                            ?>
                        @endforeach
                    </div>
                </div>
            @endforeach
                <div class="tab-pane wspay"
                     id="wspay">
                    <div class="row">
                       <div class="col-md-12">
                           <label for="enable_stripe">Enable</label><br/>
                            <input type="checkbox"  name="wspay_enable" data-plugin="switchery" data-color="#1abc9c" @if(Setting::main()->wspay_enable=="true") checked @endif   onchange="updateWspaySetting('wspay_enable',this.checked)"    />
                       </div>
                       <div class="col-md-12">
                           <label for="enable_stripe">Test Mode</label><br/>
                            <input type="checkbox"  name="wspay_mode" data-plugin="switchery" data-color="#1abc9c" @if(Setting::main()->wspay_mode=="true") checked @endif onchange="updateWspaySetting('wspay_mode',this.checked)" />
                       </div>
                       <div class="col-md-12">
                           <label for="stripe_publishable_key"> Shop ID </label>
                            <input type="text"  data-validation="" class="form-control" name="wspay_shopid" value="{{Setting::main()->wspay_shopid}}" data-post-id="" data-seo-detect=""  onchange="updateWspaySetting('wspay_shopid',this.value)" >
                       </div>
                       <div class="col-md-12">
                           <label for="stripe_publishable_key"> Secret Key </label>
                            <input type="text"  data-validation="" class="form-control" name="wspay_secret_key" value="{{Setting::main()->wspay_secret_key}}" data-post-id="" data-seo-detect=""  onchange="updateWspaySetting('wspay_secret_key',this.value)" >
                       </div>
               
                    </div>
                </div>
        </div>
    </div>
</div>


<script>
    
    async function updateWspaySetting(name,value){
        
        var formData = new FormData();
        formData.append("_token",'{{csrf_token()}}');
        formData.append(name,value);
        
        var response = await fetch("{{route('wspayUpdate')}}", {
              method: 'POST',
              body: formData
            });
            
        try {
          
          
          var ResOBJ = await response.json();
            if(ResOBJ.status==0){
                flash(0,ResOBJ.error);
            }
            
            if(ResOBJ.status==1){
                flash(1,ResOBJ.message);
                $('#user_registration_btn').show();
                $('#user_registration_spinner').hide();
                section_show('page_login');
                
                return false;
            }

        }catch(err) {

        }
        
        
    }
    
    
</script>

@if($break)
    <div class="w-100"></div> @endif
