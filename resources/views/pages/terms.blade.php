@extends('layouts.app')
@section('title', 'Termos de Uso')
@section('content')
<div class="app-container py-4 vstack gap-4 pb-5" style="max-width:48rem;">

    <div class="pt-4">
        <h1 class="fs-3 fw-bold mb-1">Termos de Uso</h1>
        <p class="small text-muted mb-0">Última actualização: {{ date('d/m/Y') }}</p>
    </div>

    <div class="card"><div class="card-body p-4 p-sm-5 small text-secondary-emphasis lh-base">

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">1. Aceitação dos Termos</h2>
            <p>Ao aceder ou utilizar a plataforma <strong>{{ config('app.name') }}</strong>, concorda com estes Termos de Uso. Se não concordar com alguma condição, deverá abster-se de utilizar a plataforma.</p>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">2. Descrição do Serviço</h2>
            <p>A {{ config('app.name') }} é um directório digital que permite a empresas e prestadores de serviço moçambicanos criarem um perfil, listar produtos e serviços, e serem encontrados por clientes. A plataforma não intervém directamente em transacções comerciais entre empresas e clientes.</p>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">3. Registo de Empresas</h2>
            <p>Para listar a sua empresa, é necessário:</p>
            <ul class="mb-2">
                <li>Fornecer informações verdadeiras e actualizadas sobre o seu negócio.</li>
                <li>Ser o representante autorizado da empresa registada.</li>
                <li>Aguardar a aprovação da equipa da plataforma antes da publicação.</li>
            </ul>
            <p>A plataforma reserva o direito de rejeitar ou remover registos que não cumpram os requisitos.</p>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">4. Conteúdo e Responsabilidades</h2>
            <p>Cada empresa é responsável pelo conteúdo que publica (produtos, descrições, imagens, preços). É proibido publicar conteúdo:</p>
            <ul class="mb-2">
                <li>Falso, enganoso ou fraudulento.</li>
                <li>Que viole direitos de terceiros (marcas, direitos de autor).</li>
                <li>Ilegal ou contrário às leis moçambicanas.</li>
                <li>Ofensivo, difamatório ou que promova discriminação.</li>
            </ul>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">5. Parceiros de Entrega</h2>
            <p>A {{ config('app.name') }} facilita a ligação entre empresas e parceiros de entrega, mas não é responsável pela execução, qualidade ou pontualidade dos serviços de entrega. Os acordos de entrega são estabelecidos directamente entre as partes.</p>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">6. Suspensão e Encerramento</h2>
            <p>A plataforma pode suspender ou encerrar contas que violem estes termos, sem aviso prévio e sem direito a reembolso de eventuais pagamentos efectuados.</p>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">7. Limitação de Responsabilidade</h2>
            <p>A {{ config('app.name') }} não garante a disponibilidade contínua do serviço e não é responsável por perdas directas ou indirectas resultantes do uso da plataforma.</p>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">8. Alterações aos Termos</h2>
            <p>Estes termos podem ser actualizados. Notificaremos os utilizadores registados por email em caso de alterações significativas. O uso continuado da plataforma após as alterações implica a aceitação dos novos termos.</p>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">9. Lei Aplicável</h2>
            <p>Estes termos regem-se pela legislação da República de Moçambique. Qualquer litígio será submetido aos tribunais competentes de Moçambique.</p>
        </section>

        <section class="mb-4">
            <h2 class="fw-semibold fs-6 mb-2">10. Contacto</h2>
            <p>Para questões relacionadas com estes termos, contacte-nos em: <a href="{{ route('contact') }}" class="link-primary text-decoration-none">página de contacto</a>.</p>
        </section>

    </div></div>
</div>
@endsection
