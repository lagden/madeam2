<section class="content">
	<header>
		<h1><?php echo $acao; ?></h1>
	</header>
	<hr/>
	<?php if($erros): ?>
	<pre class="erro">
	<?php
	foreach($erros as $msg)echo "{$msg}"."\n";
	?>
	</pre>
	<?php endif; ?>
	<div class="formulario">
		<?php
		echo \madeam\helper\Form::open($_uri,array('id'=>'frmAdmin','class'=>'frm')) . "\n";
		echo \madeam\helper\Form::hidden('Item[id]', $item->id) . "\n";
		// Path to redirect if upload files errors
		echo \madeam\helper\Form::hidden('_pathUrl', $url) . "\n";
	
		foreach((array)$frm as $k=>$v)echo \madeam\helper\Form::hidden($k, $v) . "\n";
	
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Nome</span>');
		echo \madeam\helper\Form::text('Item[nome]',$item->nome,array("autofocus"=>true,"required"=>true,"placeholder"=>"Nome completo","class"=>"big validate['required']"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Endereço</span>');
		echo \madeam\helper\Form::text('Item[endereco]',$item->endereco,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Número</span>');
		echo \madeam\helper\Form::text('Item[num]',$item->num,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Bairro</span>');
		echo \madeam\helper\Form::text('Item[bairro]',$item->bairro,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Cidade</span>');
		echo \madeam\helper\Form::text('Item[cidade]',$item->cidade,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">UF</span>');
		echo \madeam\helper\Form::text('Item[uf]',$item->uf,array("class"=>"small"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Pais</span>');
		echo \madeam\helper\Form::text('Item[pais]',$item->pais,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Tipo</span>');
		echo \madeam\helper\Form::text('Item[tipo]',$item->tipo,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Telefone</span>');
		echo \madeam\helper\Form::text('Item[telefone]',$item->telefone,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Site</span>');
		echo \madeam\helper\Form::text('Item[site]',$item->site,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Latitude</span>');
		echo \madeam\helper\Form::text('Item[latitude]',$item->latitude,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
		
		echo '<p>';
		echo \madeam\helper\Form::labelOpen('<span class="big">Longitude</span>');
		echo \madeam\helper\Form::text('Item[longitude]',$item->longitude,array("class"=>"big"));
		echo \madeam\helper\Form::labelClose();
		echo '</p>'. "\n";
	
		echo '<hr/>';
	
		echo \madeam\helper\Form::submit('Salva',array("class"=>"awesome")) . "\n";
		echo \madeam\helper\Form::button('Voltar',array("id"=>"voltaBtn",'class'=>'awesome')) . "\n";
		echo \madeam\helper\Form::close();
		?>
	</div>
</section>