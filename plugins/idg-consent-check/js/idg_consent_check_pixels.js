// Pixel variables should already be declared in head, else add them as empty variables here
idg_consent_check_pixels = idg_consent_check_pixels || {};
idg_consent_check_pixels.facebook = idg_consent_check_pixels.facebook || '';
idg_consent_check_pixels.linkedin = idg_consent_check_pixels.linkedin || '';
idg_consent_check_pixels.comscore = idg_consent_check_pixels.comscore || '';

/**
 * Load the pixels
*/
if(idg_consent_check_pixels.facebook !== ''  ) { IDG_CONSENT_CHECK.insertPixelFacebook(idg_consent_check_pixels.facebook) }
if(idg_consent_check_pixels.linkedin !== ''  ) { IDG_CONSENT_CHECK.insertPixelLinkedin(idg_consent_check_pixels.linkedin) }
if(idg_consent_check_pixels.comscore === 'on') { IDG_CONSENT_CHECK.insertPixelComscore() }