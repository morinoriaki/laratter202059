<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('通知一覧') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <h3 class="text-xl font-bold mb-4">新着通知</h3>
          @forelse ($unreadNotifications as $notification)
            <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-lg mb-2">
              <p>{{ $notification->data['tweet_text'] }} という新しいツイートが投稿されました。</p>
              <p class="text-sm text-gray-500">
                {{ $notification->created_at->diffForHumans() }}
              </p>
            </div>
          @empty
            <p>新しい通知はありません。</p>
          @endforelse

          <h3 class="text-xl font-bold mt-8 mb-4">過去の通知</h3>
          @forelse ($notifications as $notification)
            <div class="p-4 {{ $notification->read_at ? 'bg-gray-200 dark:bg-gray-700' : 'bg-blue-100 dark:bg-blue-900' }} rounded-lg mb-2">
              <p>{{ $notification->data['tweet_text'] }} という新しいツイートが投稿されました。</p>
              <p class="text-sm text-gray-500">
                {{ $notification->created_at->diffForHumans() }}
              </p>
            </div>
          @empty
            <p>通知はありません。</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-app-layout>