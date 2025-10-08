@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-10 space-y-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold">Registrar Entidade</h1>
            <p class="text-sm text-base-content/60 mt-1">Crie sua conta e a vitrine da sua entidade</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="text-sm list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="space-y-10">
            @csrf
            <div class="grid md:grid-cols-2 gap-8">
                <div class="card bg-base-100 shadow p-6 space-y-5">
                    <h2 class="font-semibold text-lg">Dados do Utilizador</h2>
                    <div class="form-control">
                        <label class="label" for="name"><span class="label-text">Nome</span></label>
                        <input id="name" name="name" value="{{ old('name') }}" required
                            class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label" for="email"><span class="label-text">Email</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label" for="password"><span class="label-text">Password</span></label>
                        <input id="password" type="password" name="password" required class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label" for="password_confirmation"><span class="label-text">Confirmar
                                Password</span></label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="input input-bordered" />
                    </div>
                </div>

                <div class="card bg-base-100 shadow p-6 space-y-5 md:row-span-2">
                    <h2 class="font-semibold text-lg">Dados da Entidade</h2>
                    <div class="form-control">
                        <label class="label" for="entity_name"><span class="label-text">Nome da Entidade</span></label>
                        <input id="entity_name" name="entity_name" value="{{ old('entity_name') }}" required
                            class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label" for="entity_description"><span class="label-text">Descrição</span></label>
                        <textarea id="entity_description" name="entity_description" rows="4" required class="textarea textarea-bordered">{{ old('entity_description') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label" for="location_city"><span class="label-text">Cidade</span></label>
                            <input id="location_city" name="location_city" value="{{ old('location_city') }}" required
                                class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label" for="location_district"><span class="label-text">Bairro</span></label>
                            <input id="location_district" name="location_district" value="{{ old('location_district') }}"
                                class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label" for="whatsapp"><span class="label-text">WhatsApp
                                    (258XXXXXXXXX)</span></label>
                            <input id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" required
                                class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label" for="phone"><span class="label-text">Telefone</span></label>
                            <input id="phone" name="phone" value="{{ old('phone') }}" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label" for="entity_email"><span class="label-text">Email da
                                    Entidade</span></label>
                            <input id="entity_email" type="email" name="entity_email"
                                value="{{ old('entity_email') }}" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label" for="facebook_url"><span class="label-text">Facebook URL</span></label>
                            <input id="facebook_url" name="facebook_url" value="{{ old('facebook_url') }}"
                                class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label" for="instagram_url"><span class="label-text">Instagram
                                    URL</span></label>
                            <input id="instagram_url" name="instagram_url" value="{{ old('instagram_url') }}"
                                class="input input-bordered" />
                        </div>
                        <div class="form-control sm:col-span-2">
                            <label class="label" for="website_url"><span class="label-text">Website</span></label>
                            <input id="website_url" name="website_url" value="{{ old('website_url') }}"
                                class="input input-bordered" />
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow p-6 space-y-5">
                    <h2 class="font-semibold text-lg">Confirmação</h2>
                    <p class="text-sm text-base-content/60">Revise os dados antes de finalizar.</p>
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">Cancelar</a>
                        <button class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
