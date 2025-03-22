<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('refractions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        $table->string('itching_right')->nullable();
        $table->string('itching_left')->nullable();
        $table->string('photophobia_right')->nullable();
        $table->string('photophobia_left')->nullable();
        $table->string('pain_right')->nullable();
        $table->string('pain_left')->nullable();
        $table->string('blur_vision_far_right')->nullable();
        $table->string('blur_vision_far_left')->nullable();
        $table->string('blur_vision_near_right')->nullable();
        $table->string('blur_vision_near_left')->nullable();
        $table->string('diplopia_right')->nullable();
        $table->string('diplopia_left')->nullable();
        $table->string('burning_sensation_right')->nullable();
        $table->string('burning_sensation_left')->nullable();
        $table->string('tearing_right')->nullable();
        $table->string('tearing_left')->nullable();
        $table->string('discharge_right')->nullable();
        $table->string('discharge_left')->nullable();
        $table->string('occipital_headache')->nullable();
        $table->string('frontal_headache')->nullable();
        $table->string('temporal_headache')->nullable();
        $table->string('hypertensive')->nullable();
        $table->string('diabetic')->nullable();
        $table->string('adnexa_right')->nullable();
        $table->string('adnexa_left')->nullable();
        $table->string('conjuctiva_right')->nullable();
        $table->string('conjuctiva_left')->nullable();
        $table->string('sclera_right')->nullable();
        $table->string('sclera_left')->nullable();
        $table->string('pupil_right')->nullable();
        $table->string('pupil_left')->nullable();
        $table->string('palpebra_right')->nullable();
        $table->string('palpebra_left')->nullable();
        $table->string('cornea_right')->nullable();
        $table->string('cornea_left')->nullable();
        $table->string('distance_right')->nullable();
        $table->string('distance_left')->nullable();
        $table->string('ph_right')->nullable();
        $table->string('ph_left')->nullable();
        $table->string('near_right')->nullable();
        $table->string('near_left')->nullable();
        $table->string('sph_glass_right')->nullable();
        $table->string('sph_glass_left')->nullable();
        $table->string('cyl_glass_right')->nullable();
        $table->string('cyl_glass_left')->nullable();
        $table->string('axis_glass_right')->nullable();
        $table->string('axis_glass_left')->nullable();
        $table->string('prism_glass_right')->nullable();
        $table->string('prism_glass_left')->nullable();
        $table->string('base_glass_right')->nullable();
        $table->string('base_glass_left')->nullable();
        $table->string('va_glass_right')->nullable();
        $table->string('va_glass_left')->nullable();
        $table->string('add_glass_right')->nullable();
        $table->string('add_glass_left')->nullable();
        $table->string('va2_glass_right')->nullable();
        $table->string('va2_glass_left')->nullable();
        $table->string('auto_refraction_right')->nullable();
        $table->string('auto_refraction_left')->nullable();
        $table->string('va_auto_right')->nullable();
        $table->string('va_auto_left')->nullable();
        $table->string('sph_retino_right')->nullable();
        $table->string('sph_retino_left')->nullable();
        $table->string('cyl_retino_right')->nullable();
        $table->string('cyl_retino_left')->nullable();
        $table->string('axis_retino_right')->nullable();
        $table->string('axis_retino_left')->nullable();
        $table->string('prism_retino_right')->nullable();
        $table->string('prism_retino_left')->nullable();
        $table->string('base_retino_right')->nullable();
        $table->string('base_retino_left')->nullable();
        $table->string('va_retino_right')->nullable();
        $table->string('va_retino_left')->nullable();
        $table->string('sph_subj_right')->nullable();
        $table->string('sph_subj_left')->nullable();
        $table->string('cyl_subj_right')->nullable();
        $table->string('cyl_subj_left')->nullable();
        $table->string('axis_subj_right')->nullable();
        $table->string('axis_subj_left')->nullable();
        $table->string('prism_subj_right')->nullable();
        $table->string('prism_subj_left')->nullable();
        $table->string('base_subj_right')->nullable();
        $table->string('base_subj_left')->nullable();
        $table->string('va_subj_right')->nullable();
        $table->string('va_subj_left')->nullable();
        $table->string('add_subj_right')->nullable();
        $table->string('add_subj_left')->nullable();
        $table->string('va2_subj_right')->nullable();
        $table->string('va2_subj_left')->nullable();
        $table->longText('diagnosis')->nullable();
        $table->longText('additional_info')->nullable();
        $table->timestamps();
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refractions');
    }
};
