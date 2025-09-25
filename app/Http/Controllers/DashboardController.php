<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Certificate;
use App\Models\Tool;
use App\Models\Career;
use App\Models\AboutMe;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener estadísticas generales
        $stats = [
            'projects_count' => Project::count(),
            'certificates_count' => Certificate::count(),
            'tools_count' => Tool::count(),
            'careers_count' => Career::count(),
        ];

        // Obtener proyectos recientes
        $recent_projects = Project::with('tools')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Obtener certificados recientes
        $recent_certificates = Certificate::with('tools')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Obtener información personal
        $about_me = AboutMe::first();

        return view('dashboard.index', compact(
            'stats',
            'recent_projects',
            'recent_certificates',
            'about_me'
        ));
    }

    public function analytics()
    {
        // Estadísticas mensuales
        $monthly_stats = [
            'projects' => Project::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get(),
            'certificates' => Certificate::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get(),
        ];

        // Herramientas más utilizadas
        $popular_tools = Tool::withCount(['projects', 'certificates'])
            ->orderByRaw('projects_count + certificates_count DESC')
            ->take(10)
            ->get();

        return view('dashboard.analytics', compact('monthly_stats', 'popular_tools'));
    }

    public function settings()
    {
        return view('dashboard.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'contact_email' => 'required|email',
        ]);

        // Actualizar configuraciones del sitio
        // Aquí puedes usar la tabla settings o el archivo .env según tu preferencia

        return redirect()->route('dashboard.settings')
            ->with('success', 'Configuraciones actualizadas correctamente');
    }
}
