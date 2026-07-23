<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Partners;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    protected function ensureSuperAdmin(): void
    {
        if (! auth()->check()) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        if (! in_array(auth()->user()?->role, ['superadmin', 'admin'], true)) {
            abort(403, 'Akses hanya untuk superadmin atau admin.');
        }
    }

    public function dashboard()
    {
        $this->ensureSuperAdmin();

        $totalUsers = User::where('role', 'user')->count();
        $totalOrganizers = User::where('role', 'organizer')->count();
        $totalOrganizations = Organization::count();
        $totalEvents = Event::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $activeEvents = Event::where('date', '>=', now())->count();
        $partnerCount = Partners::count();
        $categoryCount = Category::count();

        $monthlyUsers = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyUsers[] = [
                'label' => $month->format('M Y'),
                'value' => User::where('role', 'user')->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->count(),
            ];
        }

        $monthlyEvents = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyEvents[] = [
                'label' => $month->format('M Y'),
                'value' => Event::whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrganizers',
            'totalOrganizations',
            'totalEvents',
            'totalTransactions',
            'totalRevenue',
            'pendingTransactions',
            'activeEvents',
            'partnerCount',
            'categoryCount',
            'monthlyUsers',
            'monthlyEvents'
        ));
    }

    public function organizers()
    {
        $this->ensureSuperAdmin();

        $organizations = Organization::withCount('events')->latest()->get();

        return view('admin.organizers.index', compact('organizations'));
    }

    public function showOrganizer(Organization $organization)
    {
        $this->ensureSuperAdmin();

        $organization->load(['users', 'events.category']);
        $events = $organization->events()->with('category')->latest()->get();

        return view('admin.organizers.show', compact('organization', 'events'));
    }

    public function verifyOrganizer(Request $request, Organization $organization)
    {
        $this->ensureSuperAdmin();

        $status = $request->input('status', 'active');
        $organization->update(['status' => $status]);

        return back()->with('success', 'Status organisasi berhasil diperbarui.');
    }

    public function events()
    {
        $this->ensureSuperAdmin();

        $events = Event::with(['organization', 'category'])->latest()->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function transactions()
    {
        $this->ensureSuperAdmin();

        $transactions = Transaction::with(['event', 'organization'])->latest()->paginate(15);
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $successfulTransactions = Transaction::whereIn('status', ['settlement', 'success'])->count();

        return view('admin.transactions.index', compact('transactions', 'totalRevenue', 'pendingTransactions', 'successfulTransactions'));
    }

    public function partners()
    {
        $this->ensureSuperAdmin();

        $partners = Partners::latest()->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function createPartner()
    {
        $this->ensureSuperAdmin();

        return view('admin.partners.create');
    }

    public function storePartner(Request $request)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $logoPath = $request->file('logo')->store('partners', 'public');

        Partners::create([
            'name' => $validated['name'],
            'logo_url' => $logoPath,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan.');
    }

    public function editPartner(Partners $partner)
    {
        $this->ensureSuperAdmin();

        return view('admin.partners.edit', compact('partner'));
    }

    public function updatePartner(Request $request, Partners $partner)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
        ];

        if ($request->hasFile('logo')) {
            if ($partner->logo_url && Storage::disk('public')->exists($partner->logo_url)) {
                Storage::disk('public')->delete($partner->logo_url);
            }

            $data['logo_url'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroyPartner(Partners $partner)
    {
        $this->ensureSuperAdmin();

        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus.');
    }

    public function categories()
    {
        $this->ensureSuperAdmin();

        $categories = Category::withCount('events')->latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        $this->ensureSuperAdmin();

        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori event berhasil ditambahkan.');
    }

    public function editCategory(Category $category)
    {
        $this->ensureSuperAdmin();

        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori event berhasil diperbarui.');
    }

    public function destroyCategory(Category $category)
    {
        $this->ensureSuperAdmin();

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori event berhasil dihapus.');
    }
}
