import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ContactTableComponent } from './components/contacts/contact-table/contact-table.component';

const routes: Routes = [
  { path: 'contacts', component: ContactTableComponent},
  { path: '', redirectTo: 'contacts', pathMatch: 'full'},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
