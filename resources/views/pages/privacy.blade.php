@extends('layouts.app')
@section('title', 'Política de Privacidade')
@section('content')
<div class="max-w-3xl mx-auto space-y-6 pb-16">

    <div class="space-y-1 pt-4">
        <h1 class="text-2xl font-bold text-gray-900">Política de Privacidade</h1>
        <p class="text-xs text-gray-400">Última actualização: {{ date('d/m/Y') }}</p>
    </div>

    <div class="bg-white border rounded p-8 space-y-6 text-sm text-gray-700 leading-relaxed">

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">1. Recolha de Dados</h2>
            <p>Recolhemos os seguintes dados quando utiliza a plataforma:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Dados de registo:</strong> nome, email, palavra-passe (encriptada), dados da empresa.</li>
                <li><strong>Dados de utilização:</strong> páginas visitadas, produtos visualizados, endereço IP, tipo de browser.</li>
                <li><strong>Dados de contacto da empresa:</strong> telefone, WhatsApp, email público, localização.</li>
            </ul>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">2. Uso dos Dados</h2>
            <p>Os seus dados são utilizados para:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Operar e melhorar a plataforma.</li>
                <li>Verificar e aprovar registos de empresas.</li>
                <li>Enviar notificações relacionadas com a sua conta (aprovação, alertas de segurança).</li>
                <li>Estatísticas de utilização (de forma agregada e anónima).</li>
            </ul>
            <p>Não vendemos nem partilhamos os seus dados pessoais com terceiros para fins comerciais.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">3. Dados Públicos</h2>
            <p>Os dados que coloca no perfil público da sua empresa (nome, descrição, contacto, produtos) são visíveis para todos os visitantes da plataforma. Tenha atenção ao que decide tornar público.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">4. Cookies</h2>
            <p>Utilizamos cookies essenciais para o funcionamento da sessão (login) e cookies analíticos para perceber como a plataforma é utilizada. Não utilizamos cookies de publicidade.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">5. Segurança</h2>
            <p>As palavras-passe são armazenadas com encriptação (bcrypt). A comunicação é feita por HTTPS. Tomamos medidas razoáveis para proteger os seus dados, mas nenhum sistema é 100% seguro.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">6. Retenção de Dados</h2>
            <p>Os dados são retidos enquanto a conta estiver activa. Após o encerramento da conta, os dados são eliminados no prazo de 30 dias, excepto quando a lei exija retenção por período superior.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">7. Os Seus Direitos</h2>
            <p>Tem direito a:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Aceder aos seus dados pessoais.</li>
                <li>Corrigir dados incorrectos.</li>
                <li>Solicitar a eliminação da sua conta e dados.</li>
            </ul>
            <p>Para exercer estes direitos, contacte-nos através da <a href="{{ route('contact') }}" class="link">página de contacto</a>.</p>
        </section>

        <section class="space-y-2">
            <h2 class="font-semibold text-gray-900">8. Alterações a esta Política</h2>
            <p>Podemos actualizar esta política. Notificaremos utilizadores registados por email em caso de alterações significativas.</p>
        </section>

    </div>
</div>
@endsection
