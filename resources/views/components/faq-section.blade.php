@props(['faqData'])

<section class="bg-gray-800/50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <header class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">
                {{ __("resources.home.faq.title") }}
            </h2>
            <p class="text-gray-400">
                {{ __("resources.home.faq.subtitle") }}
            </p>
        </header>

        <div class="space-y-6" itemscope itemtype="https://schema.org/FAQPage">
            @foreach ($faqData as $faq)
            <div
                class="bg-gray-800 rounded-lg p-6"
                itemscope
                itemprop="mainEntity"
                itemtype="https://schema.org/Question"
            >
                <h3
                    class="text-lg font-semibold text-white mb-3"
                    itemprop="name"
                >
                    {{ $faq["question"] }}
                </h3>
                <div
                    itemscope
                    itemprop="acceptedAnswer"
                    itemtype="https://schema.org/Answer"
                >
                    <p class="text-gray-300 leading-relaxed" itemprop="text">
                        {{ $faq["answer"] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
