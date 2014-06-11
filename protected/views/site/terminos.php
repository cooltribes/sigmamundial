<?php
$this->pageTitle=Yii::app()->name . ' - Términos y Condiciones.';
?>

<div class="row">    
    <div class="col-md-8 col-md-offset-2 panel-gris panel-terminos">
        <!--HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <h3>Términos y Condiciones</h3>                      
                </div>
            </div>
        </div>

        <!--CONTENT-->
        <div class="row panel-content">
            <div class="col-md-12">
                <!--TEXTO-->
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <textarea class="form-control" rows="15" readonly>
                            
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vehicula eu purus sit amet varius. Nullam pulvinar ullamcorper dapibus. Ut lacinia lectus nec orci fermentum varius. Vestibulum vehicula vitae risus ut eleifend. Pellentesque et nisi nec elit viverra cursus. Nunc euismod tortor a ullamcorper consectetur. Sed vulputate eleifend dolor quis consequat. Phasellus consequat tortor magna, eget sodales mauris placerat in.

Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean purus velit, placerat vitae diam ac, condimentum semper libero. Curabitur semper, mauris vel faucibus commodo, ipsum ante viverra mi, in dignissim neque est et purus. Nam facilisis, nisl non pellentesque pulvinar, lectus lorem bibendum nisl, pellentesque congue nulla odio ac nulla. Ut non sem sed quam commodo gravida eget quis libero. Integer tincidunt mi orci, eget blandit velit fermentum auctor. Vivamus ut dui nulla. Aliquam sed elit velit. Proin bibendum varius metus ut aliquet. Donec congue leo augue, sit amet tempus magna porttitor a.

Morbi elementum eu turpis sit amet blandit. Morbi vitae dignissim dolor, non bibendum mauris. Ut id lorem sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec at libero nisl. Nam ut odio ultricies, bibendum nisl ac, interdum augue. Nulla facilisi. Duis non tortor at justo molestie pretium. Maecenas hendrerit augue a neque dignissim sollicitudin. Pellentesque quis magna sit amet mauris consequat vulputate sed et enim. Pellentesque placerat mauris at erat lobortis accumsan. Sed vestibulum pellentesque scelerisque. Integer sodales enim ac justo egestas egestas. Praesent fermentum elementum ipsum, nec consequat massa dignissim eu.

Nunc ut risus vel libero fermentum molestie. Morbi malesuada ut quam ut pulvinar. Nullam tincidunt odio magna, a iaculis enim cursus id. Cras adipiscing fringilla laoreet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam malesuada ullamcorper nibh id laoreet. Curabitur mollis hendrerit ipsum ac blandit. Etiam vulputate dapibus enim. Donec lacinia semper quam, at bibendum nisl accumsan id. Sed fringilla eu mauris non lobortis. Aliquam metus leo, tempor at tortor non, rutrum sollicitudin tellus. Morbi consectetur nulla mauris, a venenatis felis dignissim eu. Pellentesque fringilla massa hendrerit magna gravida, congue ultricies mauris consequat. Sed laoreet ligula vitae justo semper, quis consectetur sapien pretium.

                        </textarea>
                    </div>
                </div>
                <!--BOTON-->
                <div class="row boton-regresar">
                    <div class="col-md-12">
                        <?php
                        echo BsHtml::linkButton('Regresar', array(
                            'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                            'url' => array("/"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>