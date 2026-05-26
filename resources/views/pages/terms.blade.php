@extends('layouts.app')
@section('title', 'Termos de Uso')
@section('content')
<div class="max-w-3xl mx-auto space-y-6 pb-16">

    <div class="space-y-1 pt-4">
        <h1 class="text-2xl font-bold text-gray-900">Termos de Uso</h1>
        <p class="text-xs text-gray-400">Última actualização: {{ date('d/m/Y') }}</p>
    </div>

    <div class="bg-white border rounded p-8 space-y-6 text-sm text-gray-700 leading-relaxed">

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">1. Aceitação dos Termos</h2>
            <p>Ao aceder ou utilizar a plataforma <strong>{{ config('app.name') }}</strong>, concorda com estes Termos de Uso. Se não concordar com alguma condição, deverá abster-se de utilizar a plataforma.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">2. Descrição do Serviço</h2>
            <p>A {{ config('app.name') }} é um directório digital que permite a empresas e prestadores de serviço moçambicanos criarem um perfil, listar produtos e serviços, e serem encontrados por clientes. A plataforma não intervém directamente em transacções comerciais entre empresas e clientes.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">3. Registo de Empresas</h2>
            <p>Para listar a sua empresa, é necessário:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Fornecer informações verdadeiras e actualizadas sobre o seu negócio.</li>
                <li>Ser o representante autorizado da empresa registada.</li>
                <li>Aguardar a aprovação da equipa da plataforma antes da publicação.</li>
            </ul>
            <p>A plataforma reserva o direito de rejeitar ou remover registos que não cumpram os requisitos.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">4. Conteúdo e Responsabilidades</h2>
            <p>Cada empresa é responsável pelo conteúdo que publica (produtos, descrições, imagens, preços). É proibido publicar conteúdo:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Falso, enganoso ou fraudulento.</li>
                <li>Que viole direitos de terceiros (marcas, direitos de autor).</li>
                <li>Ilegal ou contrário às leis moçambicanas.</li>
                <li>Ofensivo, difamatório ou que promova discriminação.</li>
            </ul>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">5. Parceiros de Entrega</h2>
            <p>A {{ config('app.name') }} facilita a ligação entre empresas e parceiros de entrega, mas não é responsável pela execução, qualidade ou pontualidade dos serviços de entrega. Os acordos de entrega são estabelecidos directamente entre as partes.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">6. Suspensão e Encerramento</h2>
            <p>A plataforma pode suspender ou encerrar contas que violem estes termos, sem aviso prévio e sem direito a reembolso de eventuais pagamentos efectuados.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">7. Limitação de Responsabilidade</h2>
            <p>A {{ config('app.name') }} não garante a disponibilidade contínua do serviço e não é responsável por perdas directas ou indirectas resultantes do uso da plataforma.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">8. Alterações aos Termos</h2>
            <p>Estes termos podem ser actualizados. Notificaremos os utilizadores registados por email em caso de alterações significativas. O uso continuado da plataforma após as alterações implica a aceitação dos novos termos.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">9. Lei Aplicável</h2>
            <p>Estes termos regem-se pela legislação da República de Moçambique. Qualquer litígio será submetido aos tribunais competentes de Moçambique.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">10. Contacto</h2>
            <p>Para questões relacionadas com estes termos, contacte-nos em: <a href="{{ route('contact') }}" class="link">página de contacto</a>.</p>
        </section>

    </div>
</div>
@endsection
