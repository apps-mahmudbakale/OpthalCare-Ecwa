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
        $table->text('itching_right')->nullable();
        $table->text('itching_left')->nullable();
        $table->text('photophobia_right')->nullable();
        $table->text('photophobia_left')->nullable();
        $table->text('pain_right')->nullable();
        $table->text('pain_left')->nullable();
        $table->text('blur_vision_far_right')->nullable();
        $table->text('blur_vision_far_left')->nullable();
        $table->text('blur_vision_near_right')->nullable();
        $table->text('blur_vision_near_left')->nullable();
        $table->text('diplopia_right')->nullable();
        $table->text('diplopia_left')->nullable();
        $table->text('burning_sensation_right')->nullable();
        $table->text('burning_sensation_left')->nullable();
        $table->text('tearing_right')->nullable();
        $table->text('tearing_left')->nullable();
        $table->text('discharge_right')->nullable();
        $table->text('discharge_left')->nullable();
        $table->text('occipital_headache')->nullable();
        $table->text('frontal_headache')->nullable();
        $table->text('temporal_headache')->nullable();
        $table->text('hypertensive')->nullable();
        $table->text('diabetic')->nullable();
        $table->text('adnexa_right')->nullable();
        $table->text('adnexa_left')->nullable();
        $table->text('conjuctiva_right')->nullable();
        $table->text('conjuctiva_left')->nullable();
        $table->text('sclera_right')->nullable();
        $table->text('sclera_left')->nullable();
        $table->text('pupil_right')->nullable();
        $table->text('pupil_left')->nullable();
        $table->text('palpebra_right')->nullable();
        $table->text('palpebra_left')->nullable();
        $table->text('cornea_right')->nullable();
        $table->text('cornea_left')->nullable();
        $table->text('distance_right')->nullable();
        $table->text('distance_left')->nullable();
        $table->text('ph_right')->nullable();
        $table->text('ph_left')->nullable();
        $table->text('near_right')->nullable();
        $table->text('near_left')->nullable();
        $table->text('sph_glass_right')->nullable();
        $table->text('sph_glass_left')->nullable();
        $table->text('cyl_glass_right')->nullable();
        $table->text('cyl_glass_left')->nullable();
        $table->text('axis_glass_right')->nullable();
        $table->text('axis_glass_left')->nullable();
        $table->text('prism_glass_right')->nullable();
        $table->text('prism_glass_left')->nullable();
        $table->text('base_glass_right')->nullable();
        $table->text('base_glass_left')->nullable();
        $table->text('va_glass_right')->nullable();
        $table->text('va_glass_left')->nullable();
        $table->text('add_glass_right')->nullable();
        $table->text('add_glass_left')->nullable();
        $table->text('va2_glass_right')->nullable();
        $table->text('va2_glass_left')->nullable();
        $table->text('auto_refraction_right')->nullable();
        $table->text('auto_refraction_left')->nullable();
        $table->text('va_auto_right')->nullable();
        $table->text('va_auto_left')->nullable();
        $table->text('sph_retino_right')->nullable();
        $table->text('sph_retino_left')->nullable();
        $table->text('cyl_retino_right')->nullable();
        $table->text('cyl_retino_left')->nullable();
        $table->text('axis_retino_right')->nullable();
        $table->text('axis_retino_left')->nullable();
        $table->text('prism_retino_right')->nullable();
        $table->text('prism_retino_left')->nullable();
        $table->text('base_retino_right')->nullable();
        $table->text('base_retino_left')->nullable();
        $table->text('va_retino_right')->nullable();
        $table->text('va_retino_left')->nullable();
        $table->text('sph_subj_right')->nullable();
        $table->text('sph_subj_left')->nullable();
        $table->text('cyl_subj_right')->nullable();
        $table->text('cyl_subj_left')->nullable();
        $table->text('axis_subj_right')->nullable();
        $table->text('axis_subj_left')->nullable();
        $table->text('prism_subj_right')->nullable();
        $table->text('prism_subj_left')->nullable();
        $table->text('base_subj_right')->nullable();
        $table->text('base_subj_left')->nullable();
        $table->text('va_subj_right')->nullable();
        $table->text('va_subj_left')->nullable();
        $table->text('add_subj_right')->nullable();
        $table->text('add_subj_left')->nullable();
        $table->text('va2_subj_right')->nullable();
        $table->text('va2_subj_left')->nullable();
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
