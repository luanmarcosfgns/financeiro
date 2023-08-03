<?php

namespace App\Console\Commands\CrudGenerator\Template;

class ViewMold
{
    public static function buildView()
    {
       $views = self::mold();
       self::renderIndex($views);
    }
    public static function mold()
    {
        $data = [];
        $data['index'] = '@extends("layouts.app")

@section("content")
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="input-group">
                        <input
                            id="indexSearch"
                            type="text"
                            name="search"
                            placeholder="@lang(crud.common.search)"
                            value="{{ $search ?? "" }}"
                            class="form-control"
                            autocomplete="off"
                        />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="icon ion-md-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                @can("create", App\Models\:model::class)
                <a href="{{ route(":table.create") }}" class="btn btn-primary">
                    <i class="icon ion-md-add"></i>
                    @lang(crud.common.create)
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">:modelLabel</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        :theadTr
                    </thead>
                    <tbody>
                        @forelse($:table as :tableSingular)
                            :tbodyTr
                        @empty
                        <tr>
                            <td colspan="13">
                                @lang("crud.common.no_items_found")
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="13">{!! $:table->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
';
        $data['show'] = '@extends("layouts.app")

@section("content")
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route(":table.index") }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang("crud.:table.show_title")
            </h4>

            <div class="mt-4">
                :colData
            </div>

            <div class="mt-4">
                <a href="{{ route(":table.index") }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang("crud.common.back")
                </a>


                <a href="{{ route(":table.create") }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang("crud.common.create")
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
';
        $data['edit'] = '@extends("layouts.app")

@section("content")
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route(":table.index") }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang("crud.:table.edit_title")
            </h4>

            <x-form
                method="PUT"
                action="{{ route(":table.update", $pessoa) }}"
                class="mt-4"
            >
                @include("app.:table.form-inputs")

                <div class="mt-4">
                    <a
                        href="{{ route(":table.index") }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang("crud.common.back")
                    </a>

                    <a
                        href="{{ route(":table.create") }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-add text-primary"></i>
                        @lang("crud.common.create")
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang("crud.common.update")
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
';
        $data['create'] = '@extends("layouts.app")

@section("content")
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route(":table.index") }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang("crud.:table.create_title")
            </h4>

            <x-form
                method="POST"
                action="{{ route(":table.store") }}"
                class="mt-4"
            >
                @include("app.:table.form-inputs")

                <div class="mt-4">
                    <a
                        href="{{ route(":table.index") }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang("crud.common.back")
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang("crud.common.create")
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
';
        $data['form-inputs'] = '<div class="row">
        :inputForms
    </div>';
        return $data;
    }

    private static function renderIndex(array $views)
    {
    }
}
