<?php $state_property = $table . '_state'; 

// Getting the last revision here: 
$last_revision = null;
if ( count( $revisions ) > 0 ) :
    $last_revision = $revisions[ count( $revisions ) - 1 ];
    $language_property = $table . '_content_language';
    if ( $last_revision->$language_property != Oak::$site_language ) :
        foreach( $revisions as $revision ) :
            if ( $revision->$language_property == Oak::$site_language ) :
                $last_revision = $revision;
            endif;
        endforeach;
    endif;
endif;
?>

<!-- initializing property names -->
<?php 
$designation_property = $table . '_designation';
$identifier_property = $table . '_identifier';
$selector_property = $table . '_selector';
$locked_property = $table . '_locked';
$trashed_property = $table . '_trashed';
$state_property = $table . '_state';
$modification_time_property = $table . '_modification_time';
?>

<div class="oak_element_header">
    <div class="oak_element_header_left">
        <i class="oak_menu_icon oak_menu_icon__cancel_icon fas fa-times"></i>

        <?php 
        $number_of_elements_selected_text = '';
        if ( $table == 'form' ) :
            $number_of_elements_selected_text = 'Champ(s) sélectionné(s)';
        elseif ( $table == 'model' ) :
            $number_of_elements_selected_text = 'Modèle(s) sélectinné(s)';
        endif;
        ?>
        <h3 class="oak_element_header_title"><?php echo( $title ); ?></h3>
        <?php if ( $table == 'form' || $table == 'model' ) : ?> 
        <span class="oak_selected_other_elements_number_indicator">
            <span class="oak_number_of_selected_elements_text">-</span> 
            <span class="oak_number_of_other_selected_elements">0</span>
            <span class="oak_number_of_selected_elements_text"><?php echo( $number_of_elements_selected_text ); ?></span>
        </span>
        <?php endif; ?>
    </div>
    <div class="oak_element_header_right">
        <div class="oak_select_container">
            <span class="text_field_description"><?php _e( 'Langue', Oak::$text_domain ); ?></span>
            <div class="additional_container">
                <select class="oak_element_header_right__elements_select">
                    <?php
                    foreach( $elements as $element ) : ?>
                        <option <?php if( $_GET[ $identifer_property ] == $element->$identifier_property ) : echo('selected'); endif; ?> value="<?php echo( $element->$identifier_property); ?>"><?php echo( $element->$designation_property ); ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
            <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
        </div>

        <?php
        if ( isset( $_GET[ $table . '_identifier'] ) && $last_revision->$state_property == 1 ) : ?>
            <div class="oak_add_element_container__draft_button">
                <span><?php _e( 'Retour à l\'état de Brouillon', Oak::$text_domain ); ?></span>
            </div>
        <?php 
        endif;
        if ( isset( $_GET[ $table . '_identifier'] ) ) : 
            $add_text = '';
            if ( $last_revision->$state_property == 0 ) :
                $add_text = 'Sauvegarder le brouillon';
            elseif ( $last_revision->$state_property == 1 ) :
                $add_text = 'Enregistrer';
            else :
                $add_text = 'Mettre à jour';
            endif;
            ?>
            <div class="oak_add_element_container__update_button">
                <span><?php echo( $add_text ); ?></span>
            </div>
        <?php
        else : ?>
            <div class="oak_add_element_container__add_button">
                <span><?php _e( 'Ajouter au Brouillon', Oak::$text_domain ); ?></span>
            </div>
        <?php
        endif; 
        ?>
        
        <div class="oak_add_element_container__register_button <?php if ( isset( $_GET[ $table . '_identifier'] ) && $last_revision->$state_property == 1 ) : echo( 'oak_hidden' ); endif; ?>">
            <?php 
            $text = 'Enregistrer';
            if ( isset( $_GET[ $table . '_identifier'] ) && $last_revision->$state_property == '2' ) :
                $text = 'Retour à l\'état enregistré';
            endif;
            ?>
            <span><?php echo( $text ); ?></span>
        </div>

        <?php
        if ( isset( $_GET[ $table . '_identifier'] ) && $last_revision->$state_property == '1' ) : ?>
            <div class="oak_add_element_container__broadcast_button">
                <span><?php _e( 'Diffuser', Oak::$text_domain ); ?></span>
            </div>
            <?php
        endif;
        ?>
    </div>

    <div class="oak_element_header_right_other_elements_buttons oak_hidden">
        <i class="oak_other_elements_copy_button oak_menu_icon oak_menu_smaller_icon fas fa-copy"></i>
        <i class="oak_other_elements_delete_button oak_menu_icon oak_menu_smaller_icon fas fa-trash"></i>
    </div>
</div>
<!-- Done with the top bars -->

<div class="oak_add_element_container__header">
    <img class="oak_add_element_container_header_icon" src="<?php echo( get_template_directory_uri() . '/src/assets/icons/fields.png' ); ?>" alt="">
    <h3 class="oak_add_element_container__title"><?php echo( $title ); ?></h3>
</div>
    
<div class="oak_add_element_big_container">
    <div class="oak_add_element_container">
        
        <div class="oak_add_element_container__horizontal_container">
            <!-- For the designation -->
            <div class="oak_text_field_container">
                <input type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $last_revision->$designation_property ) ); endif; ?>" class="oak_text_field <?php echo( $table . '_designation_input' ); ?>">
                <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $last_revision->$designation_property != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php _e( 'Designation', Oak::$text_domain ); ?></span>
                <div class="text_field_line <?php if( count( $revisions ) > 0 && $last_revision->$designation_property != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                <span class="text_field_description"><?php _e('Nom'); ?></span>
            </div>

            <!-- For the identifier -->
            <div class="oak_text_field_container_identifier">
                <input placeholder="Identifiant Unique  " type="text" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $last_revision->$identifier_property ) ); endif; ?>" disabled class="oak_text_field <?php echo( $table . '_identifier_input' ); ?>">
                <span class="oak_text_field_placeholder"></span>
                <div class="text_field_line"></div>
                <span class="text_field_description"><?php _e('Identifiant technique'); ?></span>
            </div>

            <!-- For the selector -->
            <div class="oak_checkbox_container">
                <div class="oak_checkbox_container__container">
                    <span class="oak_text_field_checkbox_description"><?php _e( 'Sélecteur de cadre RSE', Oak::$text_domain ); ?></span>
                    <input name="selector" type="checkbox" <?php if ( isset( $last_revision->$selector_property ) && $last_revision->$selector_property == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_element_container__input <?php echo( $table . '_selector_input' ); ?>">
                </div>
                <div class="input_line"></div>
                <span class="text_field_description"><?php _e('Objects de cadres RSE'); ?></span>
            </div>
        </div>

        <?php 
        $selectors_values = [];
        if ( $table == 'object' && count( $revisions ) > 0 ) :
            $properties_and_selectors = explode( '|', $last_revision->object_selectors );
            foreach( $properties_and_selectors as $property_and_selector ) :
                if ( $property_and_selector != '' ) :
                    $selectors_values[] = array(
                        'property' => explode( ':', $property_and_selector )[0],
                        'selector_value' => explode( ':', $property_and_selector )[1]
                    );
                endif;
            endforeach;
        endif; 

        $first = true;
        $form_designation = '';
        $model_and_form_id = '';
        $the_model = null;
        foreach( $properties as $key => $property ) :
            if ( isset( $property['model_and_form_instance'] ) ) :
                // For the field new designation: 
                $model_fields_names = '';
                foreach( Oak::$models_without_redundancy as $model ) :
                    if ( $model->model_identifier == $property['model_and_form_instance']->model_identifier ) :
                        $model_fields_names = $model->model_fields_names;
                        $the_model = $model;
                    endif;
                endforeach;
                $model_fields_names_array = explode( '|', $model_fields_names );
                $property['description'] = $model_fields_names_array[ $key ];
                // For the form new designation: 
                $form_new_designation = $property['form']->form_designation;
                $model_and_form_new_id = $property['model_and_form_instance']->id;
                if ( $property['model_and_form_instance']->form_designation != '' ) :
                    $form_new_designation = $property['model_and_form_instance']->form_designation;
                endif;
                if ( $form_designation != $form_new_designation || $model_and_form_id != $model_and_form_new_id ) :
                    $form_designation = $form_new_designation;
                    $model_and_form_id = $property['model_and_form_instance']->id;
                ?>
                    <div class="oak_add_element_container__horizontal_container">
                        <h2 class="oak_add_element_formula_title"><?php echo( $form_new_designation ); ?></h2>
                    </div>
                    <?php 
                    $property['width'] = '100';
                    ?>
                <?php
                endif;
            endif;

            $beginning = false;
            if ( isset( $property['line'] ) && $property['line'] == 'beginning' ) :
                $beginning = true;
            endif;

            if ( $table == 'performance' && $property['name'] == 'publication' ) : ?>
                <h2 class="oak_formula_title"><?php _e( 'Résultats', Oak::$text_domain ); ?></h2>
                <div class="oak_performance_results_container">
                    <div class="oak_single_performance_result oak_hidden oak_add_element_container__horizontal_container"> 
                        <div class="oak_superficial_results_container">
                            <input type="checkbox" class="oak_add_other_elements_list_single_element__chekcbox">

                            <div class="oak_select_container ">
                                <div class="additional_container">
                                    <select type="text" class="oak_add_element_container__input performance_goal_year_input">
                                        <option notselected="" value="1990">1990</option>
                                        <option notselected="" value="1991">1991</option>
                                        <option notselected="" value="1992">1992</option>
                                        <option notselected="" value="1993">1993</option>
                                        <option notselected="" value="1994">1994</option>
                                        <option notselected="" value="1995">1995</option>
                                        <option notselected="" value="1996">1996</option>
                                        <option notselected="" value="1997">1997</option>
                                        <option notselected="" value="1998">1998</option>
                                        <option notselected="" value="1999">1999</option>
                                        <option notselected="" value="2000">2000</option>
                                        <option notselected="" value="2001">2001</option>
                                        <option notselected="" value="2002">2002</option>
                                        <option notselected="" value="2003">2003</option>
                                        <option notselected="" value="2004">2004</option>
                                        <option notselected="" value="2005">2005</option>
                                        <option notselected="" value="2006">2006</option>
                                        <option notselected="" value="2007">2007</option>
                                        <option notselected="" value="2008">2008</option>
                                        <option notselected="" value="2009">2009</option>
                                        <option notselected="" value="2010">2010</option>
                                        <option notselected="" value="2011">2011</option>
                                        <option notselected="" value="2012">2012</option>
                                        <option notselected="" value="2013">2013</option>
                                        <option notselected="" value="2014">2014</option>
                                        <option notselected="" value="2015">2015</option>
                                        <option notselected="" value="2016">2016</option>
                                        <option notselected="" value="2017">2017</option>
                                        <option notselected="" value="2018">2018</option>
                                        <option notselected="" value="2019">2019</option>
                                        <option notselected="" value="2020">2020</option>
                                        <option notselected="" value="2021">2021</option>
                                        <option notselected="" value="2022">2022</option>
                                        <option notselected="" value="2023">2023</option>
                                        <option notselected="" value="2024">2024</option>
                                        <option notselected="" value="2025">2025</option>
                                        <option notselected="" value="2026">2026</option>
                                        <option notselected="" value="2027">2027</option>
                                        <option notselected="" value="2028">2028</option>
                                        <option notselected="" value="2029">2029</option>
                                        <option notselected="" value="2030">2030</option>
                                        <option notselected="" value="2031">2031</option>
                                        <option notselected="" value="2032">2032</option>
                                        <option notselected="" value="2033">2033</option>
                                        <option notselected="" value="2034">2034</option>
                                        <option notselected="" value="2035">2035</option>
                                        <option notselected="" value="2036">2036</option>
                                        <option notselected="" value="2037">2037</option>
                                        <option notselected="" value="2038">2038</option>
                                        <option notselected="" value="2039">2039</option>
                                        <option notselected="" value="2040">2040</option>
                                        <option notselected="" value="2041">2041</option>
                                        <option notselected="" value="2042">2042</option>
                                        <option notselected="" value="2043">2043</option>
                                        <option notselected="" value="2044">2044</option>
                                        <option notselected="" value="2045">2045</option>
                                        <option notselected="" value="2046">2046</option>
                                        <option notselected="" value="2047">2047</option>
                                        <option notselected="" value="2048">2048</option>
                                        <option notselected="" value="2049">2049</option>
                                        <option notselected="" value="2050">2050</option>
                                        <option notselected="" value="2051">2051</option>
                                        <option notselected="" value="2052">2052</option>
                                        <option notselected="" value="2053">2053</option>
                                        <option notselected="" value="2054">2054</option>
                                        <option notselected="" value="2055">2055</option>
                                        <option notselected="" value="2056">2056</option>
                                        <option notselected="" value="2057">2057</option>
                                        <option notselected="" value="2058">2058</option>
                                        <option notselected="" value="2059">2059</option>
                                        <option notselected="" value="2060">2060</option>
                                        <option notselected="" value="2061">2061</option>
                                        <option notselected="" value="2062">2062</option>
                                        <option notselected="" value="2063">2063</option>
                                        <option notselected="" value="2064">2064</option>
                                        <option notselected="" value="2065">2065</option>
                                        <option notselected="" value="2066">2066</option>
                                        <option notselected="" value="2067">2067</option>
                                        <option notselected="" value="2068">2068</option>
                                        <option notselected="" value="2069">2069</option>
                                        <option notselected="" value="2070">2070</option>
                                        <option notselected="" value="2071">2071</option>
                                        <option notselected="" value="2072">2072</option>
                                        <option notselected="" value="2073">2073</option>
                                        <option notselected="" value="2074">2074</option>
                                        <option notselected="" value="2075">2075</option>
                                        <option notselected="" value="2076">2076</option>
                                        <option notselected="" value="2077">2077</option>
                                        <option notselected="" value="2078">2078</option>
                                        <option notselected="" value="2079">2079</option>
                                        <option notselected="" value="2080">2080</option>
                                        <option notselected="" value="2081">2081</option>
                                        <option notselected="" value="2082">2082</option>
                                        <option notselected="" value="2083">2083</option>
                                        <option notselected="" value="2084">2084</option>
                                        <option notselected="" value="2085">2085</option>
                                        <option notselected="" value="2086">2086</option>
                                        <option notselected="" value="2087">2087</option>
                                        <option notselected="" value="2088">2088</option>
                                        <option notselected="" value="2089">2089</option>
                                        <option notselected="" value="2090">2090</option>
                                        <option notselected="" value="2091">2091</option>
                                        <option notselected="" value="2092">2092</option>
                                        <option notselected="" value="2093">2093</option>
                                        <option notselected="" value="2094">2094</option>
                                        <option notselected="" value="2095">2095</option>
                                        <option notselected="" value="2096">2096</option>
                                        <option notselected="" value="2097">2097</option>
                                        <option notselected="" value="2098">2098</option>
                                        <option notselected="" value="2099">2099</option>
                                        <option notselected="" value="2100">2100</option>
                                        <option notselected="" value="2101">2101</option>
                                        <option notselected="" value="2102">2102</option>
                                        <option notselected="" value="2103">2103</option>
                                        <option notselected="" value="2104">2104</option>
                                        <option notselected="" value="2105">2105</option>
                                        <option notselected="" value="2106">2106</option>
                                        <option notselected="" value="2107">2107</option>
                                        <option notselected="" value="2108">2108</option>
                                        <option notselected="" value="2109">2109</option>
                                        <option notselected="" value="2110">2110</option>
                                        <option notselected="" value="2111">2111</option>
                                        <option notselected="" value="2112">2112</option>
                                        <option notselected="" value="2113">2113</option>
                                        <option notselected="" value="2114">2114</option>
                                        <option notselected="" value="2115">2115</option>
                                        <option notselected="" value="2116">2116</option>
                                        <option notselected="" value="2117">2117</option>
                                        <option notselected="" value="2118">2118</option>
                                        <option notselected="" value="2119">2119</option>
                                        <option notselected="" value="2120">2120</option>
                                        <option notselected="" value="2121">2121</option>
                                        <option notselected="" value="2122">2122</option>
                                        <option notselected="" value="2123">2123</option>
                                        <option notselected="" value="2124">2124</option>
                                        <option notselected="" value="2125">2125</option>
                                        <option notselected="" value="2126">2126</option>
                                        <option notselected="" value="2127">2127</option>
                                        <option notselected="" value="2128">2128</option>
                                        <option notselected="" value="2129">2129</option>
                                        <option notselected="" value="2130">2130</option>
                                        <option notselected="" value="2131">2131</option>
                                        <option notselected="" value="2132">2132</option>
                                        <option notselected="" value="2133">2133</option>
                                        <option notselected="" value="2134">2134</option>
                                        <option notselected="" value="2135">2135</option>
                                        <option notselected="" value="2136">2136</option>
                                        <option notselected="" value="2137">2137</option>
                                        <option notselected="" value="2138">2138</option>
                                        <option notselected="" value="2139">2139</option>
                                        <option notselected="" value="2140">2140</option>
                                        <option notselected="" value="2141">2141</option>
                                        <option notselected="" value="2142">2142</option>
                                        <option notselected="" value="2143">2143</option>
                                        <option notselected="" value="2144">2144</option>
                                        <option notselected="" value="2145">2145</option>
                                        <option notselected="" value="2146">2146</option>
                                        <option notselected="" value="2147">2147</option>
                                        <option notselected="" value="2148">2148</option>
                                        <option notselected="" value="2149">2149</option>
                                        <option notselected="" value="2150">2150</option>
                                        <option notselected="" value="2151">2151</option>
                                        <option notselected="" value="2152">2152</option>
                                        <option notselected="" value="2153">2153</option>
                                        <option notselected="" value="2154">2154</option>
                                        <option notselected="" value="2155">2155</option>
                                        <option notselected="" value="2156">2156</option>
                                        <option notselected="" value="2157">2157</option>
                                        <option notselected="" value="2158">2158</option>
                                        <option notselected="" value="2159">2159</option>
                                        <option notselected="" value="2160">2160</option>
                                        <option notselected="" value="2161">2161</option>
                                        <option notselected="" value="2162">2162</option>
                                        <option notselected="" value="2163">2163</option>
                                        <option notselected="" value="2164">2164</option>
                                        <option notselected="" value="2165">2165</option>
                                        <option notselected="" value="2166">2166</option>
                                        <option notselected="" value="2167">2167</option>
                                        <option notselected="" value="2168">2168</option>
                                        <option notselected="" value="2169">2169</option>
                                        <option notselected="" value="2170">2170</option>
                                        <option notselected="" value="2171">2171</option>
                                        <option notselected="" value="2172">2172</option>
                                        <option notselected="" value="2173">2173</option>
                                        <option notselected="" value="2174">2174</option>
                                        <option notselected="" value="2175">2175</option>
                                        <option notselected="" value="2176">2176</option>
                                        <option notselected="" value="2177">2177</option>
                                        <option notselected="" value="2178">2178</option>
                                        <option notselected="" value="2179">2179</option>
                                        <option notselected="" value="2180">2180</option>
                                        <option notselected="" value="2181">2181</option>
                                        <option notselected="" value="2182">2182</option>
                                        <option notselected="" value="2183">2183</option>
                                        <option notselected="" value="2184">2184</option>
                                        <option notselected="" value="2185">2185</option>
                                        <option notselected="" value="2186">2186</option>
                                        <option notselected="" value="2187">2187</option>
                                        <option notselected="" value="2188">2188</option>
                                        <option notselected="" value="2189">2189</option>
                                        <option notselected="" value="2190">2190</option>
                                        <option notselected="" value="2191">2191</option>
                                        <option notselected="" value="2192">2192</option>
                                        <option notselected="" value="2193">2193</option>
                                        <option notselected="" value="2194">2194</option>
                                        <option notselected="" value="2195">2195</option>
                                        <option notselected="" value="2196">2196</option>
                                        <option notselected="" value="2197">2197</option>
                                        <option notselected="" value="2198">2198</option>
                                        <option notselected="" value="2199">2199</option>
                                        <option notselected="" value="3000">3000</option>
                                    </select>
                                </div>
                                <div class="input_line"></div>
                                <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                                <span class="text_field_description">Année.</span>
                            </div>                
                            <div class="oak_text_field_container">
                                <div class="additional_container">
                                    <input value="" class="oak_text_field performance_goal_input">
                                </div>
                                <span class="oak_text_field_placeholder">Valeur</span>
                                <div class="text_field_line"></div>
                                <span class="text_field_description">Valeur.</span>
                            </div>
                            <div class="oak_checkbox_container">
                                <div class="oak_checkbox_container__container">
                                    <span class="oak_text_field_checkbox_description">Estimation</span>
                                    <input name="selector" type="checkbox" class="oak_add_element_container__input performance_estimated_input">
                                </div>
                                <div class="input_line"></div>
                                <span class="text_field_description"></span>
                            </div>            
                            <div class="oak_checkbox_container">
                                <div class="oak_checkbox_container__container">
                                    <span class="oak_text_field_checkbox_description">Aucune valeur</span>
                                    <input name="selector" type="checkbox" class="oak_add_element_container__input performance_no_value_input">
                                </div>
                                <div class="input_line"></div>
                                <span class="text_field_description"></span>
                            </div>
                        </div>   
                    </div>

                    <div class="oak_performance_result_add_button">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>


                <h2 class="oak_formula_title"><?php _e( 'Liason', Oak::$text_domain ); ?></h2>
            <?php
            endif;

            if ( $property['width'] == '100' || $first || $beginning ) : 
            ?>
                <div class="oak_add_element_container__horizontal_container"><?php
            endif;

            $property_name = $property['property_name'];

            if ( $property['input_type'] == 'text' || $property['input_type'] == 'number' ) : ?>
                <div class="oak_text_field_container">
                    <?php 
                    $input_class_prefix = '';
                    if ( $_GET['elements'] == 'objects' ) :
                        $input_class_prefix = 'object_';
                    endif;
                    ?>
                    <div class="additional_container">
                        <input  value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $last_revision->$property_name ) ); endif; ?>" class="oak_text_field <?php echo( $table . '_' . $property['name'] . '_input' ) ?>">
                    </div>
                    <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $last_revision->$property_name != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php echo( $property['placeholder'] ); ?></span>
                    <div class="text_field_line <?php if( count( $revisions ) > 0 && $last_revision->property_name != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>
                </div><?php
            elseif ( $property['input_type'] == 'textarea' ) : ?>
                <div class="oak_text_field_container">
                    <?php 
                    $input_class_prefix = '';
                    if ( $_GET['elements'] == 'objects' ) :
                        $input_class_prefix = 'object_';
                    endif;
                    ?>
                    <div class="additional_container">
                        <textarea class="oak_text_field <?php echo( $table . '_' . $property['name'] . '_input' ) ?>" name="" id="" cols="30" rows="5"  ><?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $last_revision->$property_name ) ); endif; ?></textarea>
                    </div>
                    <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $last_revision->$property_name != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php echo( $property['placeholder'] ); ?></span>
                    <div class="text_field_line <?php if( count( $revisions ) > 0 && $last_revision->property_name != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>
                </div><?php
            elseif ( $property['input_type'] == 'color' ) : ?>
                <div class="oak_select_container">
                    <?php 
                    $input_class_prefix = '';
                    if ( $_GET['elements'] == 'objects' ) :
                        $input_class_prefix = 'object_';
                    endif;
                    ?>
                    <div class="color_additional_container">
                        <input type="<?php echo( $property['input_type'] ); ?>" value="<?php if ( count( $revisions ) > 0 ) : echo( esc_attr( $last_revision->$property_name ) ); endif; ?>" class="oak_color <?php echo( $table . '_' . $property['name'] . '_input' ) ?>">
                    </div>
                    <div class="text_field_line <?php if( count( $revisions ) > 0 && $last_revision->property_name != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>
                </div><?php
            elseif ( $property['input_type'] == 'select' ) : ?>
                <div class="oak_select_container <?php if( isset( $property['hidden'] ) ) : if( $property['hidden'] == 'true' ) : echo('oak_hidden'); endif; endif; ?>">
                    <div class="additional_container">
                        <select <?php if( $property['select_multiple'] == 'true' ) : echo('multiple'); endif; ?> type="text" class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_input' ) ?>">
                            <?php 
                            $selected = array();
                            foreach( $property['choices'] as $key => $choice ) :
                                array_push( $selected, 'notselected' );
                                if ( count( $revisions ) > 0 ) :
                                    $selected_in_database = explode( '|', $last_revision->$property_name );
                                    foreach( $selected_in_database as $single_selected_in_database ) :
                                        if ( $single_selected_in_database ==  $choice['value'] ) :
                                            $selected[ $key ] = 'selected';
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                                <option <?php echo( esc_attr( $selected[ $key ] ) ); ?> value="<?php echo( $choice['value'] ); ?>"><?php echo( $choice['innerHTML'] ); ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="input_line"></div>
                    <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>
                </div><?php
            elseif ( $property['input_type'] == 'checkbox' ) : ?>
                <div class="oak_checkbox_container">
                    <div class="oak_checkbox_container__container">
                        <span class="oak_text_field_checkbox_description"><?php echo( $property['placeholder'] ); ?></span>
                        <input name="selector" type="checkbox" <?php if ( isset( $last_revision->$property_name ) && $last_revision->$property_name == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_input' ); ?>">
                    </div>
                    <div class="input_line"></div>
                    <span class="text_field_description"><?php $property['description'] ?></span>
                </div>
            <?php
            elseif ( $property['input_type'] == 'image' || $property['input_type'] == 'file' ) : ?>
                <div class="oak_checkbox_container oak_add_element_image_container">
                    <div class="oak_checkbox_container__container">
                        <?php if ( $property['input_type'] == 'image' ) : ?>
                            <a property-name='<?php echo( $property['name'] ); ?>' class="oak_calling_selector_image calling_selector_<?php echo( $property['name'] ); ?>" data-attachment_ids="12" href="#"><?php _e( 'Choisir une image', Oak::$text_domain ); ?></a>
                            <img id="my-image" class="oak_add_element_image_container <?php echo( 'oak_file_' . $property['name'] ); ?>" src="<?php if ( count( $revisions ) > 0 ) : echo( $last_revision->$property_name ); endif; ?>" />
                            <input class="oak_file_input <?php echo( $table . '_' . $property['name'] . '_input' ); ?>" type="hidden" />
                        <?php else: ?>
                            <a 
                                property-name='<?php echo( $property['name'] ); ?>' 
                                class="oak_calling_selector_file calling_selector_<?php echo( $property['name'] ); ?>" 
                                href="#" 
                                data-uploader_title="<?php _e( 'Selectionnez un fichier' ); ?>" 
                                data-attachment_ids="[34,35,36]"

                            >
                            <?php _e( 'Cliquez ici pour attacher un PDF', Oak::$text_domain ); ?>
                            </a>
                            <input class="oak_file_input <?php echo( $table . '_' . $property['name'] . '_input' ); ?>" disabled value="<?php if ( count( $revisions ) > 0 ) : echo( $last_revision->$property_name ); endif; ?>" />

                        <?php endif; ?>
                    </div>

                    <div class="input_line"></div>
                    <span class="text_field_description"><?php echo ( $property['description'] ); ?></span>
                </div>
            <?php
            elseif ( $property['input_type'] == 'quali' || $property['input_type'] == 'quanti' ) : ?>
                <div class="oak_select_container">
                    <div class="additional_container">
                        <select type="text" class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_input' ) ?>">
                            <option value="0"><?php _e( 'Aucun indicateur selectionné', Oak::$text_domain ); ?></option>
                            <?php 
                            $selected = array();
                            $choices = $property['input_type'] == 'quali' ? Oak::$qualis_without_redundancy : Oak::$quantis_without_redundancy;
                            $quali_or_quanti = $property['input_type'] == 'quali' ? 'quali' : 'quanti';
                            foreach( $choices as $key => $choice ) :
                                $identifier_property = $quali_or_quanti . '_identifier';
                                $designation_property = $quali_or_quanti . '_designation';
                                array_push( $selected, 'notselected' );
                                if ( count( $revisions ) > 0 ) :
                                    if ( $last_revision->$property_name == $choice->$identifier_property ) :
                                        $selected[ $key ] = 'selected';
                                    endif;
                                endif;
                                ?>
                                <option <?php echo( esc_attr( $selected[ $key ] ) ); ?> value="<?php echo( $choice->$identifier_property ); ?>"><?php echo( $choice->$designation_property ); ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="input_line"></div>
                    <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>
                </div> <?php
            elseif ( $property['input_type'] == 'selector' ) :
                $choices = [];
                $field_identifier = explode( '_', $property['name'] )[1];
                foreach( Oak::$fields_without_redundancy as $field ) :
                    if ( $field->field_identifier == $field_identifier ) :
                        $field_selector_options = $field->field_selector_options;
                        $choices = explode( '|', $field_selector_options );
                    endif;
                endforeach;
                ?>
                <div class="oak_select_container">
                    <div class="additional_container">
                        <select type="text" class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_input' ) ?>">
                            <option value="0"><?php _e( 'Aucune valeur selectionée', Oak::$text_domain ); ?></option>
                            <?php 
                            $selected = array();
                            foreach( $choices as $key => $choice ) :
                                array_push( $selected, 'notselected' );
                                if ( count( $revisions ) > 0 ) :
                                    if ( $last_revision->$property_name == $choice ) :
                                        $selected[ $key ] = 'selected';
                                    endif;
                                endif;
                                ?>
                                <option <?php echo( esc_attr( $selected[ $key ] ) ); ?> value="<?php echo( $choice ); ?>"><?php echo( $choice ); ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="input_line"></div>
                    <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>
                </div>
            <?php
            elseif ( $property['input_type'] == 'select_with_filters' ) : ?>
            <div class="oak_select_container oak_select_container_with_filters_for_<?php echo( $property['name'] ); ?> oak_select_container_with_filters <?php if( isset( $property['hidden'] ) ) : if( $property['hidden'] == 'true' ) : echo('oak_hidden'); endif; endif; ?>">
                <div class="additional_container">
                    <input type="text" hidden value="<?php echo( $last_revision->$property_name ); ?>" class="<?php echo( $table . '_' . $property['name'] . '_input' ) ?>" >
                </div>

                <div class="<?php if ( $property['can_add_more'] == 'false' ) : echo('oak_hidden'); endif; ?> oak_select_container_with_filters__add_button">
                    <i class="fas fa-plus"></i>
                </div>

                <div can-add-more="<?php echo( $property['can_add_more'] ); ?>" class="oak_select_container_with_filters__single_element">
                    <div class="additional_container">
                        <select type="text" class="oak_add_element_container__input oak_select_container_with_filters_single_element__data_select">
                            <?php
                            $selected = array();
                            foreach( $property['choices'] as $key => $choice ) :
                                $filter_properties = '';
                                foreach( $property['filters'] as $filter ) :
                                    if ( isset( $choice['data'] ) ) :
                                        $the_table = explode( '_', array_keys( get_object_vars( $choice['data'] ) )[1] )[0];
                                        $filter_property_name = $the_table . '_' . $filter['name'];
                                        $filter_properties .= $filter['name'] . '="' . $choice['data']->$filter_property_name . '" ';
                                    endif;
                                endforeach;
                                ?>
                                <option <?php if( isset( $choice['data'] ) && $filter_properties != '' ) : echo( $filter_properties ); endif; ?> value="<?php echo( $choice['value'] ); ?>"><?php echo( $choice['innerHTML'] ); ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="input_line"></div>
                    <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                    <span class="text_field_description"><?php echo( $property['description'] ); ?></span>

                    <div class="oak_select_container__filters_container">
                        <?php 
                        foreach( $property['filters'] as $filter ) : ?>
                        <div class="oak_select_container__single_filter">
                            <select property-name="<?php echo( $filter['name'] ); ?>" type="text" class="oak_select_container__filter_select oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_input' ) ?>">
                                <?php 
                                foreach( $filter['choices'] as $key => $choice ) :
                                    ?>
                                    <option value="<?php echo( $choice['value'] ); ?>"><?php echo( $choice['innerHTML'] ); ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <div class="input_line"></div>
                            <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                            <span class="text_field_description filter_description"><?php echo( $filter['description'] ); ?></span>
                        </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>

            </div><?php
            endif;
            
            $showed_a_selector = false;
            if ( isset( $property['selector'] ) ) :
                if ( $property['selector'] == 'true' ) :
                    $showed_a_selector = true;
                    ?>
                    <div class="oak_select_container oak_select_container__selector">
                        <div class="additional_container">
                            <select multiple type="text" class="oak_add_element_container__input <?php echo( $table . '_' . $property['name'] . '_selector' ) ?>">
                                <option value="0"><?php _e( 'Aucun object selectionné', Oak::$text_domain ); ?></option>
                                <?php 
                                foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) : 
                                    $selected = '';
                                    foreach( $selectors_values as $selector_value ) :
                                        if ( $selector_value['property'] == $property['name'] && $selector_value['selector_value'] == $frame_object->object_identifier ) :
                                            $selected = 'selected';
                                        endif;
                                    endforeach; 
                                ?>
                                    <option <?php echo( $selected ); ?> value="<?php echo( $frame_object->object_identifier ); ?>"><?php echo( $frame_object->object_designation ); ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="input_line"></div>
                        <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                        <span class="text_field_description"><?php _e( 'Selecteur de cadres RSE', Oak::$text_domain ); ?></span>
                    </div>
                    <?php
                endif;
            endif;

            // For the form selector
            $at_the_end_of_form = false;
            if ( isset( $property['model_and_form_instance'] ) ) :
                $model_and_form_id = $property['model_and_form_instance']->id;
                $at_the_end_of_form = false;
                if ( $key == count( $properties ) - 1 ) :
                    $at_the_end_of_form = true;
                elseif( $properties[ $key + 1 ]['model_and_form_instance']->id != $model_and_form_id ) :
                    $at_the_end_of_form = true;
                endif;

                // We are gonna set the selector for the previous form:
                if ( $property['form']->form_selector == 'true' && $at_the_end_of_form ) :
                    $showed_a_selector = true;
                    ?>
                    <div class="oak_select_container oak_select_container__selector">
                        <div class="additional_container">
                            <select multiple type="text" class="oak_add_element_container__input <?php echo( 'object_form_selector' ) ?>" form-identifier="<?php echo( $property['form']->form_identifier ); ?>">
                                <option value="0"><?php _e( 'Aucun object selectionné', Oak::$text_domain ); ?></option>
                                <?php 
                                $object_form_selectors_attributes = [];
                                if ( count( $revisions ) > 0 ) :
                                    $object_form_selectors = $last_revision->object_form_selectors;
                                    $object_form_selectors = explode( '|', $object_form_selectors );
                                    foreach( $object_form_selectors as $selector ) :
                                        if ( $selector != '' ) :
                                            $attributes = explode( '_', $selector );
                                            
                                            $object_form_selectors_attributes[] = array(
                                                'form' => $attributes[1],
                                                'object' => $attributes[3]
                                            );
                                        endif;
                                    endforeach;
                                endif;
                                
                                foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) : 
                                    $selected = '';
                                    foreach( $object_form_selectors_attributes as $object_form_attributes ) :
                                        if ( $object_form_attributes['form'] == $property['form']->form_identifier && $object_form_attributes['object'] == $frame_object->object_identifier ) :
                                            $selected = 'selected';
                                        endif;
                                    endforeach; 
                                ?>
                                    <option <?php echo( $selected ); ?> value="<?php echo( $frame_object->object_identifier ); ?>"><?php echo( $frame_object->object_designation ); ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="input_line"></div>
                        <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                        <span class="text_field_description"><?php _e( 'Selecteur de cadres RSE pour le formulaire', Oak::$text_domain ); ?></span>
                    </div>
                    <?php
                endif;
            endif;

            $close_div = $property['width'] == '100' || !$first || $showed_a_selector || $at_the_end_of_form || $key == count( $properties ) - 1;
            if ( isset( $property['line'] ) ) :
                if ( $property['line'] == 'beginning' || $property['line'] == 'dont_return' ) :
                    $close_div = false;
                elseif ( $property['line'] == 'end_of_line' ) :
                    // var_dump('should close here');
                    $close_div = true;
                endif;
            endif;
            
            if ( $close_div ) : ?>
                </div>
            <?php 
            endif;

            if ( $close_div )
                $first = true;
            if ( !$close_div && $first ) :
                $first = false;
            endif;
                
                
        endforeach;

        // For the model selector:
        if ( $the_model != null ) : 
            if ( $the_model->model_selector == 'true' ) :
            ?>
                <div class="oak_select_container oak_select_container__selector">
                    <div class="additional_container">
                        <select multiple type="text" class="oak_add_element_container__input object_model_selector">
                            <option value="0"><?php _e( 'Aucun object selectionné', Oak::$text_domain ); ?></option>
                            <?php
                            $object_model_selector = '';
                            if ( $last_revision != null ) :
                                if ( $last_revision->object_model_selector != null ) :
                                    $object_model_selector = $last_revision->object_model_selector;
                                endif;
                            endif;
                            $selected_objects = explode( '|', $object_model_selector );

                            foreach( Oak::$all_frame_objects_without_redundancy as $frame_object ) : 

                                $selected = '';
                                if ( in_array( $frame_object->object_identifier, $selected_objects ) ) :
                                    $selected = 'selected';
                                endif;
                            ?>
                                <option <?php echo( $selected ); ?> value="<?php echo( $frame_object->object_identifier ); ?>"><?php echo( $frame_object->object_designation ); ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="input_line"></div>
                    <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                    <span class="text_field_description"><?php _e( 'Selecteur de cadres RSE pour l’objec en entier', Oak::$text_domain ); ?></span>
                </div>
            <?php
            endif;
        endif;

        ?>

        <!-- // This is for objects (We are gonna associate them to the terms) -->
        <?php 
        if ( $_GET['elements'] == 'objects' ) : ?>
            <div class="oak_objects_terms">
            <?php
            foreach( Oak::$taxonomies_without_redundancy as $taxonomy ) : ?>
                <div class="oak_add_element_terms_atribution_single_element">
                    <span class="oak_add_element_taxonomy_title"><?php echo( $taxonomy->taxonomy_designation ); ?></span>
                    <div class="autocomplete" style="width:300px;">
                        <div class="oak_admin_autocomplete_selections_container">
                            <?php 
                            if ( isset( $_GET['object_identifier'] ) ) :
                                foreach( Oak::$terms_and_objects as $term_and_object ) :
                                    if ( $term_and_object->object_identifier == $_GET['object_identifier'] ) :
                                        foreach( Oak::$all_terms_without_redundancy as $term ) :
                                            if ( $term->term_taxonomy_identifier == $taxonomy->taxonomy_identifier && $term->term_identifier == $term_and_object->term_identifier ) : ?>
                                                <div class="oak_autocomplete_selected_input_container">
                                                    <input type="text" disabled value="<?php echo ( $term->term_designation ); ?>" identifier="<?php echo( $term->term_identifier ); ?>" class="oak_autocomplete_selected_input">
                                                    <i class="oak_autocomplete_delete_button fas fa-minus"></i>
                                                </div>
                                            <?php
                                            endif;
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;

                            if ( isset( $_GET['term_identifier'] ) ) :
                                foreach( Oak::$all_terms_without_redundancy as $term ) :
                                    if ( $term->term_taxonomy_identifier == $taxonomy->taxonomy_identifier && $term->term_identifier == $_GET['term_identifier'] ) : ?>
                                        <div class="oak_autocomplete_selected_input_container">
                                            <input type="text" disabled value="<?php echo ( $term->term_designation ); ?>" identifier="<?php echo( $term->term_identifier ); ?>" class="oak_autocomplete_selected_input">
                                            <i class="oak_autocomplete_delete_button fas fa-minus"></i>
                                        </div>
                                    <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </div>
                        <input type="text" class="oak_autocomplete_input">
                        <select class="oak_autocomplete_select oak_hidden" id=""> 
                            <?php
                            foreach( Oak::$all_terms_without_redundancy as $term ) :
                                if ( $term->term_taxonomy_identifier == $taxonomy->taxonomy_identifier ) : ?>
                                    <option value="<?php echo( $term->term_identifier ); ?>"><?php echo( $term->term_designation ); ?></option>
                                <?php
                                endif;
                            endforeach;
                        ?>
                        </select>
                    </div>
                </div>
            <?php
            endforeach; ?>
            </div>
            <?php
        endif;
        ?>

        <?php
        if ( $table == 'form' || $table == 'model' ) :
            if ( $table == 'form' ) 
                $other_properties = Oak::$form_other_elements;
            if ( $table == 'model' )
                $other_properties = Oak::$model_other_elements;
        ?>
            <div class="oak_other_elements_container">
                <h2 class="oak_other_elements_container__title"><?php echo( $other_properties['title'] ); ?></h2>
                
                <div class="oak_other_elements_container__add_button">
                    <i class="fas fa-plus"></i>
                </div>

                <div class="oak_other_elements__single_elements_container">
                    <div class="oak_other_elements_single_elements_container__single_element oak_other_elements_single_elements_container__single_element_not_checked">
                        <div class="oak_other_elements_single_elements_container__final_selector_container">
                            <input type="checkbox" class="oak_add_other_elements_list_single_element__chekcbox">
                            <div class="oak_select_container">
                                <select type="text" class="oak_other_elements_select oak_add_element_container__input">
                                    <option value=""><?php echo( $other_properties['first_option'] ); ?></option>
                                    <?php
                                        foreach( $other_properties['elements'] as $element ) :
                                            $identifer_property = $other_properties['table'] . '_identifier';
                                            $designation_property = $other_properties['table'] . '_designation';

                                            $designation = $element->$designation_property;

                                            $language_property = $table . '_content_language'; 
                                            if ( !$element->$language_property == Oak::$site_language ) :
                                                // Lets get the last designation for the current site language of the considered element (If we don't find it, we apply the last modification)
                                                foreach( $other_properties['elements_with_redundancy'] as $other_occurence ) :
                                                    if ( $other_occurence->$identifier_property == $element->$identifier_property && $other_occurence->$language_property == Oak::$site_language ) :
                                                        $designation = $other_occurence->$designation_property;
                                                    endif;
                                                endforeach;
                                            endif;
                                            ?>
                                            <option value="<?php echo( $element->$identifer_property ); ?>"><?php echo( $designation ); ?></option>
                                            <?php
                                        endforeach;
                                    ?>
                                </select>
                                <div class="input_line"></div>
                                <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                                <span class="text_field_description"><?php echo( $other_properties['description'] ); ?></span>
                            </div>

                            <div class="oak_text_field_container">
                                <input type="text" value="" class="oak_text_field designation_input">
                                <span class="oak_text_field_placeholder <?php if( count( $revisions ) > 0 && $last_revision->$designation_property != '' ) : echo('oak_text_field_placeholder_not_focused_but_something_written'); endif; ?>"><?php _e( 'Nouvelle désignation', Oak::$text_domain ); ?></span>
                                <div class="text_field_line <?php if( count( $revisions ) > 0 && $last_revision->$designation_property != '' ) : echo('text_field_line_not_focused_but_something_written'); endif; ?>"></div>
                                <span class="text_field_description"><?php echo( $other_properties['new_designation_description'] ); ?></span>
                            </div>

                            <div class="oak_checkbox_container">
                                <div class="oak_checkbox_container__container">
                                    <span class="oak_text_field_checkbox_description"><?php _e( 'Requis', Oak::$text_domain ); ?></span>
                                    <input name="selector" type="checkbox" <?php if ( isset( $last_revision->$selector_property ) && $last_revision->$selector_property == 'true' ) : echo( 'checked' ); endif; ?> class="oak_add_element_container__input selector_input">
                                </div>
                                <div class="input_line"></div>
                                <span class="text_field_description"><?php _e('Requis ou non lors du remplissage'); ?></span>
                            </div>
                        </div>
                        
                        <div class="oak_filters_container">
                            <?php
                                foreach( $other_properties['filters'] as $filter ) : ?>
                                    <div class="oak_select_container">
                                        <select type="text" class="oak_other_elements_select oak_add_element_container__input <?php echo( $filter['filter_name'] ); ?>">
                                            <option value="0"><?php echo( $filter['first_option'] ); ?></option>
                                            <?php
                                                foreach( $filter['choices'] as $choice ) :
                                                    ?>
                                                    <option value="<?php echo( $choice['value'] ); ?>"><?php echo( $choice['innerHTML'] ); ?></option>
                                                    <?php
                                                endforeach;
                                            ?>
                                        </select>
                                        <div class="input_line"></div>
                                        <i class="oak_select_container__bottom_arrow fas fa-caret-down"></i>
                                        <span class="text_field_description"><?php echo( $filter['title'] ); ?></span>
                                    </div>
                                <?php 
                                endforeach;
                            ?>
                        </div>

                        <div class="oak_model_fields_renaming_container">

                        </div>
                    </div>
                </div>
            </div>
        <?php 
        endif; 
        ?>
    </div>

    
    
    <div class="oak_add_element_big_container__tabs">
        <div class="oak_add_element_big_container_tabs__titles">
            <h4 class="oak_add_element_big_container_tabs_titles__single_title oak_add_element_big_container_tabs_titles__single_title_selected"><?php _e( 'Champ', Oak::$text_domain ); ?></h4>
        </div>

        <div class="oak_add_element_big_container_tabs__single_tab">
            <div class="oak_add_element_big_container_tabs_single_tab__section">
                <h5 class="oak_add_element_big_container_tabs_single_tab_section__title"><?php _e( 'Status et Visibilité: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state_label"><?php _e( 'Etat: ', Oak::$text_domain ); ?></span>
                    <?php 
                    $state = 'Brouillon';
                    if ( isset( $_GET[ $table . '_identifier'] ) ) :
                        if ( $last_revision->$state_property == '0' ) : 
                            $state = 'Brouillon';
                        elseif ( $last_revision->$state_property == '1' ) :
                            $state = 'Enregistré';
                        else : 
                            $state = 'Diffusé';
                        endif;
                    endif;
                    ?>
                    <span><?php echo( $state ); ?></span>
                </div>

                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state_label"><?php _e( 'Révisions: ', Oak::$text_domain ); ?></span>
                    <div class="oak_add_element_big_container_tabs_single_tab_section_state__info_container">
                        <span><?php 
                            if ( count( $revisions ) > 0 ) :
                                echo( count( $revisions ) - 1 );
                            else :
                                echo('0');
                            endif; 
                            ?>
                        </span>
                        <span class="oak_add_element_big_container_tabs_single_tab_section_state__browse">
                            <?php _e( 'Parcourir', Oak::$text_domain ); ?>
                        </span>
                    </div>
                </div>
                <?php
                    $registration_date = $broadcast_date = __( 'Pas encore', Oak::$text_domain );

                    if ( count( $revisions ) > 0 ) :
                        $last_revision = $revisions[ count( $revisions ) - 1 ];

                        $modification_time_property = $table . '_modification_time';

                        if ( $last_revision->$state_property == 1 ) :
                            $registration_date = $last_revision->$modification_time_property;
                        elseif ( $last_revision->$state_property == 2 ) :
                            $broadcast_date = $last_revision->$modification_time_property;
                            $index = 0;
                            for ( $i = count( $revisions ) - 2; $i >= 0; $i-- ) :
                                if ( $revisions[ $i ]->$state_property == 1 ) :
                                    $registration_date = $revisions[ $i ]->$modification_time_property;
                                endif;
                            endfor;
                        endif;
                    endif;
                ?>
                
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state_label"><?php _e( 'Enregistré le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state__info"><?php echo( $registration_date ); ?></span>
                </div>

                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state_label"><?php _e( 'Diffusé le: ', Oak::$text_domain ); ?></span>
                    <?php 
                    ?>
                    <span class="oak_add_element_big_container_tabs_single_tab_section_state__info"><?php echo( $broadcast_date ); ?></span>
                </div>
            </div>

            <div class="oak_add_element_big_container_tabs_single_tab__section">
                <h5 class="oak_add_element_big_container_tabs_single_tab_section__title"><?php _e( 'Formulaires: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_element_big_container_tabs_single_tab_section__formulas_select" name="" id="">
                        <?php 
                        if ( count( $revisions ) > 0 ) :
                            $found_field = false;
                            $forms_counter = 0;
                            do {
                                $form_fields_array = explode( '|', Oak::$forms_without_redundancy[ $forms_counter ]->form_fields );
                                $form_fields_counter = 0;
                                do {
                                    $field_data = explode( ':', $form_fields_array[ $form_fields_counter ] );
                                    if ( count( $field_data ) > 1 ) :
                                        if ( $field_data[1] == $last_revision->$identifier_property ) : 
                                            $found_field = true;
                                        ?>
                                            <option value="<?php Oak::$forms_without_redundancy[ $forms_counter ]->form_identifier ?>"><?php echo( esc_attr( Oak::$forms_without_redundancy[ $forms_counter ]->form_designation ) ); ?></option>
                                        <?php
                                        endif;
                                    endif;
                                    $form_fields_counter++;
                                } while( !$found_field && $form_fields_counter < count( $form_fields_array ) );
                                $forms_counter++;
                            } while ( $forms_counter < count( Oak::$forms_without_redundancy ) );
                        endif;
                        ?>
                    </select>

                    <span class="oak_select_go_button"><?php _e( 'Accéder', Oak::$text_domain ); ?></span>
                </div>
            </div>

            <div class="oak_add_element_big_container_tabs_single_tab__section">
                <h5 class="oak_add_element_big_container_tabs_single_tab_section__title"><?php _e( 'Modèles: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_element_big_container_tabs_single_tab_section__formulas_select" name="" id="">
                    <?php 
                        if ( count( $revisions ) > 0 ) :
                            foreach( Oak::$models_without_redundancy as $model ) :
                                $model_forms_array = explode( '|', $model->model_forms );
                                $model_forms_counter = 0;
                                $found_field = false;
                                do {
                                    $form_data = explode( ':', $model_forms_array[ $model_forms_counter ] );
                                    if ( count( $form_data ) > 0 ) :
                                        $form_identifier = $form_data[1];
                                        $oak_forms_counter = 0;
                                        do {
                                            if ( Oak::$forms_without_redundancy[ $oak_forms_counter ]->form_identifier == $form_identifier ) :
                                                $form_fields_array = explode( '|', Oak::$forms_without_redundancy[ $oak_forms_counter ]->form_fields );
                                                $form_fields_counter = 0;
                                                do {
                                                    $fields_data = explode( ':', $form_fields_array[ $form_fields_counter ] );
                                                    if ( count( $fields_data ) > 1 ) :
                                                        if ( $fields_data[1] == $last_revision->$identifier_property ) : 
                                                            $found_field = true;
                                                        ?>
                                                            <option value="<?php $model->model_identifier ?>"><?php echo( esc_attr( $model->model_designation ) ); ?></option>
                                                        <?php
                                                        endif;
                                                    endif;
                                                    $form_fields_counter++;
                                                } while ( !$found_field && $form_fields_counter < count( $form_fields_array ) );
                                            endif;
                                            $oak_forms_counter++;
                                        } while ( !$found_field && $oak_forms_counter < count ( Oak::$forms_without_redundancy ) );
                                    endif;
                                    $model_forms_counter++;
                                } while ( !$found_field && $model_forms_counter < count( $model_forms_array ) );
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>

            <div class="oak_add_element_big_container_tabs_single_tab__section">
                <h5 class="oak_add_element_big_container_tabs_single_tab_section__title"><?php _e( 'Publications: ', Oak::$text_domain ); ?></h5>
                <div class="oak_add_element_big_container_tabs_single_tab_section__state">
                    <select class="oak_add_element_big_container_tabs_single_tab_section__formulas_select" name="" id=""></select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- For the modal -->
<div class="oak_add_element_modal_container">
    <div class="oak_add_element_modal_container__modal">
        <div class="oak_add_element_modal_container_modal__title_container">
            <h3 class="oak_add_element_modal_container_modal_title_container__title"></h3>
        </div>

        <div class="oak_add_element_modal_container_modal__content">

            <!-- For the browse revisions functionality -->
            
            <div class="oak_add_element_modal_container_modal_content__revisions_content oak_hidden">
                
                <div class="oak_add_element_modal_container_modal_content__revisions_content__current">
                    <h3><?php _e( 'Données Actuelle', Oak::$text_domain); ?></h3>
                    <!-- List of fields here -->
                    <?php 
                        $default_properties = array(
                            array( 'name' => 'designation', 'type' => 'text', 'description' => 'Designation' ),
                            array( 'name' => 'identifier', 'type' => 'text', 'description' => 'Identifiant' ),
                            array( 'name' => 'selector', 'type' => 'checkbox', 'description' => 'Selecteur de cadres RSE' ),
                            array( 'name' => 'locked', 'type' => 'checkbox', 'description' => 'Vérouillé' ),
                            array( 'name' => 'trashed', 'type' => 'checkbox', 'description' => 'Corbeille' ),
                            array( 'name' => 'state', 'type' => 'checkbox', 'description' => 'Etat' ),
                        );
                    ?>
                    <?php 
                    $which_properties = $table . '_properties'; 
                    $class = new ReflectionClass('Oak');
                    $properties = array_merge( $default_properties, $class->getStaticPropertyValue( $which_properties ) );
                    
                    foreach( $properties as $property ) : ?>
                        <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                            <label><?php echo( $property['description'] ); ?></label>
                            <input name="type" type="text" disabled class="oak_revision_<?php echo( $property['name'] ); ?>_field_current" value="">
                        </div>
                    <?php
                    endforeach;
                    
                    if ( $table == 'form' || $table == 'model' ) : ?>
                        <?php 
                        $element_inputs = array ( 
                            __( 'Désignation', Oak::$text_domain ), 
                            __( 'Identifiant', Oak::$text_domain ), 
                            __( 'renommage', Oak::$text_domain ), 
                            __( 'Sélecteur cadres RSE', Oak::$text_domain ) 
                        );
                        ?>
                        <div class="oak_other_elements_revision_inputs">
                            <h2 class="oak_other_elements_revision_title"><?php echo( $other_properties['title'] ); ?></h2>
                            <div class="oak_other_elements_revision_inputs__single_element_container">
                                <?php 
                                    foreach( $element_inputs as $element_input ) : ?>
                                        <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                                            <label><?php echo( $element_input ); ?></label>
                                            <input name="type" type="text" disabled value="">
                                        </div>
                                    <?php
                                    endforeach;
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
                
                <div class="oak_add_element_modal_container_modal_content_revisions_content__revision_data_container">
                    <h3><?php _e( 'Données de la révision', Oak::$text_domain); ?></h3>
                    <!-- Liste of fields here -->
                    <?php
                    foreach( $properties as $property ) : ?>
                        <div class="oak_add_element_modal_container_modal_content_revisions_data_content__single_data">
                            <label><?php echo( $property['description'] ); ?></label>
                            <input name="type" type="text" disabled class="oak_revision_<?php echo( $property['name'] ); ?>_field" value="">
                        </div>
                    <?php 
                    endforeach;

                    if ( $table == 'form' || $table == 'model' ) : ?>
                        <div class="oak_other_elements_actual_revision_revision_inputs">
                            <h2 class="oak_other_elements_revision_title"><?php echo( $other_properties['title'] ); ?></h2>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>

                <div class="oak_add_element_modal_container_modal_content_revisions_content__list_of_revisions">
                    <h3><?php _e( 'Liste des révisions', Oak::$text_domain ); ?></h3>
                    <?php 
                    // Lets get the list of languages first: 
                    $languages_codes = [];
                    $language_property = $table . '_content_language';
                    var_dump( $table );
                    foreach( $revisions as $key => $revision ) :
                        if ( !in_array( $revision->$language_property, $languages_codes ) ) :
                            $languages_codes[] = $revision->$language_property;
                            ?>
                                <h2 class="oak_add_element_modal_container_content_revisions_list_of_revisions__language_title"><?php echo( $revision->$language_property ); ?></h2>
                            <?php 
                            foreach( $revisions as $revision_to_add ) :
                                if ( $revision_to_add->$language_property == $revision->$language_property ) : ?>
                                    <div index="<?php echo( $key ) ?>" class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                        <?php
                                        ?>
                                        <span class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( esc_attr( $revision->$modification_time_property ) ); ?></span>
                                    </div>
                                <?php

                                endif;
                            endforeach;
                        endif;
                        /*if ( $key != count( $revisions ) - 1 ) :
                        ?>
                            <div index="<?php echo( $key ) ?>" class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision">
                                <?php
                                ?>
                                <span class="oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions_single_revision__date"><?php echo( esc_attr( $revision->$modification_time_property ) ); ?></span>
                            </div>
                        <?php
                        endif;*/
                    endforeach;
                    ?>
                </div>
            </div>
            <!-- Done with the browse revisions Functionality -->

        </div>

        <span class="oak_add_element_modal_container_modal__error"></span>
        <div class="oak_add_element_modal_container_modal__buttons_container">
            <div class="oak_add_element_modal_container_modal_buttons_container__cancel_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_cancel_button_container__text" >
                    Annuler
                </span>
            </div>
            
            <div class="oak_add_element_modal_container_modal_buttons_container__add_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_add_button_container__text" >
                    Ajouter
                </span>
            </div>

            <div class="oak_add_element_modal_container_modal_buttons_container__ok_button_container">
                <span class="oak_add_element_modal_container_modal_buttons_container_add_button_container__text" >
                    Ok
                </span>
            </div>
        </div>
        
    </div>
    <div class="oak_loader"></div>
</div>