<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-lg">{{ $project->name }}</h3>
        <span @class([
            'px-2 py-1 rounded text-xs font-bold uppercase',
            'bg-blue-100 text-blue-700' => $project->status === 'ongoing',
            'bg-green-100 text-green-700' => $project->status === 'completed',
        ])>
            {{ $project->status }}
        </span>
    </div>

    <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
    </div>
    <p class="text-right text-xs font-bold text-blue-600">{{ $project->progress_percentage }}% Complete</p>
</div>