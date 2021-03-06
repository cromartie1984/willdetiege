@extends('main')

@section('title', '| Edit Blog Post')

@section('stylesheets')

{!! Html::style('css/parsley.css') !!}
{!! Html::style('css/select2.min.css') !!}

@endsection

@section('content')

<div class="row">

	{!! Form::model($post, ['route' => ['posts.update', $post->id],'method' => 'PUT', 'files' => true], ['data-parsley-validate' => '']) !!}

	<div class="col-md-8">
		
		{{ Form::label('title','Title:')}}
		{{ Form::text('title', null, ['class' => 'form-control input-lg', 'required' => '', 'maxlength' => '255'])}}

		{{ Form::label('slug','Slug:', ['class' => 'form-spacing-top'])}}
		{{ Form::text('slug', null, ['class' => 'form-control input-lg', 'required' => '', 'minlength' => '5', 'maxlength' => '255'])}}

		{{ Form::label('category_id','Category:',['class' => 'form-spacing-top'])}}
		{{ Form::select('category_id',$categories, null, ['class' => 'form-control'])}}

		{{ Form::label('tags',"Tags:",['class' => 'form-spacing-top'])}}
		{{ Form::select('tags[]',$tags, null, ['class' => 'select2-multi form-control', 'multiple'=>'multiple', 'style'=> 'width:100%'])}}

		{{ Form::label('featured_img','Update Featured Image:', ['class' => 'form-spacing-top'])}}
		{{ Form::file('featured_img')}}

		{{ Form::label('body',"Post Body:", ['class' => 'form-spacing-top'])}}
		{{ Form::textarea('body',null, ['class' => 'form-control', 'required' => ''])}}

	</div>

	<div class="col-md-4">
		<div class="well">
			<dl class="dl-horizontal">
				<dt>Create At:</dt>
				<dd>{{ date('M j, Y H:ia', strtotime($post->created_at)) }}</dd>
			</dl>
			<dl class="dl-horizontal">
				<dt>Last Updated:</dt>
				<dd>{{ date('M j, Y H:ia',strtotime($post->updated_at)) }}</dd>
			</dl>
			<hr>
			<div class="row">
				<div class="col-sm-6">
					{{ Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class' => 'btn btn-danger btn-block'))}}


				</div>
				<div class="col-sm-6">
					{{ Form::submit('Save Changes', array('class' => 'btn btn-success btn-block'))}}
				</div>
			</div>
		</div>

	</div>
	{!! Form::close() !!}
</div><!-- end of .row (form) -->

@endsection

@section('scripts')

{!! Html::script('js/parsley.min.js') !!}
{!! Html::script('js/select2.min.js') !!}

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>


<script type="text/javascript">
	$('.select2-multi').select2();

	tinymce.init({
		selector :'textarea',
		plugins:'link fullscreen',
		menubar:false
	});

</script>

@endsection